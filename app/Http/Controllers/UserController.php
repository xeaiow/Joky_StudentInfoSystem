<?php

namespace App\Http\Controllers;

use App\Department;
use App\Myclass;
use App\Section;
use App\StudentInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\CreateAdminRequest;
use App\Http\Requests\User\CreateTeacherRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\ImpersonateUserRequest;
use App\Http\Requests\User\CreateLibrarianRequest;
use App\Http\Requests\User\CreateAccountantRequest;
use Mavinoo\LaravelBatch\Batch;
use App\Events\UserRegistered;
use App\Events\StudentInfoUpdateRequested;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\User\HandleUser;
/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $school_code
     * @param $student_code
     * @param $teacher_code
     * @return \Illuminate\Http\Response
     */
    public function index($school_code, $student_code, $teacher_code)
    {
        session()->forget('section-attendance');
        if (!empty($school_code) && $student_code == 1) { // For student
            $users = HandleUser::getStudents();
            $view = 'list.student-list';
        } elseif (!empty($school_code) && $teacher_code == 1) { // For teacher
            $users = HandleUser::getTeachers();
            $view = 'list.teacher-list';
        } else {
            return view('home');
        }
        return view($view, [
            'users' => $users,
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
        ]);
    }

    /**
     * @param $school_code
     * @param $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexOther($school_code, $role)
    {
        if ($role == 'accountant') {
            $users = HandleUser::getAccountants();
            $view = 'accounts.accountant-list';
        } elseif ($role == 'librarian') {
            $users = HandleUser::getLibrarians();
            $view = 'library.librarian-list';
        } else {
            return view('home');
        }
        return view($view, [
            'users' => $users,
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToRegisterStudent()
    {
        $classes = Myclass::query()
            ->where('school_id', Auth::user()->school->id)
            ->pluck('id');

        $sections = Section::with('class')
            ->whereIn('class_id', $classes)
            ->get();

        session([
            'register_role' => 'student',
            'register_sections' => $sections,
        ]);

        return view('layouts.student.register-student', compact('classes', 'sections'));
    }

    // 新增教師頁面
    public function redirectToRegisterTeacher ()
    {
        $departments = Department::where('school_id', Auth::user()->school_id)->get();
        $classes     = Myclass::where('school_id', Auth::user()->school->id)->pluck('id');
        $sections    = Section::with('class')->whereIn('class_id',$classes)->get();
        session([
          'register_role'       => 'teacher',
          'departments'         => $departments,
          'register_sections'   => $sections
        ]);

        return view('layouts.teacher.register-teacher', compact('departments', 'classes', 'sections'));
    }

    /**
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sectionStudents($section_id)
    {
        $students = HandleUser::getSectionStudentsWithSchool($section_id);

        return view('profile.section-students', ['students' => $students]);
    }

    /**
     * @param $section_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function promoteSectionStudents($section_id)
    {
        if ($section_id > 0) {
            $students = HandleUser::getSectionStudentsWithStudentInfo($section_id);
            $classes = Myclass::with('sections')
                ->where('school_id', Auth::user()->school_id)
                ->get();
        } else {
            $students = [];
            $classes = [];
        }

        return view('school.promote-students', [
            'students' => $students,
            'classes' => $classes,
            'section_id' => $section_id,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promoteSectionStudentsPost(Request $request)
    {   
        if ($request->section_id > 0) {
            $students = HandleUser::getSectionStudents($request->section_id);
            $i = 0;
            foreach ($students as $student) {
                $st[] = [
                    'id' => $student->id,
                    'section_id' => $request->to_section[$i],
                    'active' => isset($request["left_school$i"]) ? 0 : 1,
                ];

                $st2[] = [
                    'student_id' => $student->id,
                    'session' => $request->to_session[$i],
                ];

                ++$i;
            }
            DB::transaction(function () use ($st, $st2) {
                $table1 = 'users';
                \Batch::update($table1, $st, 'id');
                $table2 = 'student_infos';
                \Batch::update($table2, $st2, 'student_id');
            });

            return back()->with('status', '更改完成');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePasswordGet()
    {
        return view('profile.change-password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePasswordPost(ChangePasswordRequest $request)
    {
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $request->user()->fill([
              'password' => Hash::make($request->new_password),
            ])->save();

            return back()->with('status', '更改成功');
        }

        return back()->with('error-status', '舊密碼錯誤');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonateGet()
    {
        if (app('impersonate')->isImpersonating()) {
            Auth::user()->leaveImpersonation();
            return redirect('/home');
        }
        else {
            return view('profile.impersonate', [
                'other_users' => User::where('id', '!=', auth()->id())->get([ 'id', 'name', 'role' ])
            ]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function impersonate(ImpersonateUserRequest $request)
    {
        $user = User::find($request->id);
        Auth::user()->impersonate($user);
        return redirect('/home');
    }


    // 新增學員
    public function stores(CreateUserRequest $request)
    {
        $exist = User::where('email', $request->email)->count();

        if ($exist != 0)
        {
            return back()->with('existed', '電子信箱已存在');
        }
        DB::transaction(function () use ($request) {
            $password = $request->password;
            $tb = HandleUser::storeStudent($request);
            try {
                // Fire event to store Student information
                if(event(new StudentInfoUpdateRequested($request,$tb->id))){
                    // Fire event to send welcome email
                    event(new UserRegistered($tb, $password));
                } else {
                    throw new \Exeception('事件回傳失敗');
                }
            } catch(\Exception $ex) {
                // Log::info('Email 寄送失敗： '.$tb->email.'\n'.$ex->getMessage());
            }
        });
        return back()->with('status', '新增成功');
    }

    // 新增教師
    public function storeTeachers(CreateTeacherRequest $request)
    {
        $exist = User::where('email', $request->email)->count();

        if ($exist != 0)
        {
            return back()->with('existed', '電子信箱已存在');
        }
        DB::transaction(function () use ($request) {
            $password = $request->password;
            $tb = HandleUser::storeTeacher($request);
            try {
                // Fire event to send welcome email
                event(new UserRegistered($tb, $password));
            } catch(\Exception $ex) {
                Log::info('Email 寄送失敗： '.$tb->email);
            }
        });
        return back()->with('status', '新增成功');
    }

    /**
     * @param CreateAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(CreateAdminRequest $request)
    {
        $password = $request->password;
        $tb = HandleUser::storeAdmin($request);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email 寄送失敗： '.$tb->email);
        }

        return back()->with('status', '新增成功');
    }

    /**
     * @param CreateAccountantRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAccountant(CreateAccountantRequest $request)
    {
        $password = $request->password;
        $tb = HandleUser::storeAccountant($request);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email 寄送失敗： '.$tb->email);
        }

        return back()->with('status', '新增成功');
    }

    /**
     * @param CreateLibrarianRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLibrarian(CreateLibrarianRequest $request)
    {
        $password = $request->password;
        $tb = HandleUser::storeLibrarian($request);
        try {
            // Fire event to send welcome email
            event(new UserRegistered($tb, $password));
        } catch(\Exception $ex) {
            Log::info('Email 寄送失敗： '.$tb->email);
        }

        return back()->with('status', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return UserResource
     */
    public function show($user_code)
    {
        $user = HandleUser::getUserByUserCode($user_code);

        return view('profile.user', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $classes = Myclass::query()
            ->where('school_id', Auth::user()->school_id)
            ->pluck('id')
            ->toArray();

        $sections = Section::query()
            ->whereIn('class_id', $classes)
            ->get();

        $departments = Department::query()
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'sections' => $sections,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $tb = User::find($request->user_id);
            $tb->name = $request->name;
            $tb->email = (!empty($request->email)) ? $request->email : '';
            $tb->phone_number = $request->phone_number;
            $tb->address = (!empty($request->address)) ? $request->address : '';
            $tb->about = (!empty($request->about)) ? $request->about : '';
            $tb->pic_path = (!empty($request->pic_path)) ? $request->pic_path : '';
            if ($request->user_role == 'teacher') {
                $tb->department_id = $request->department_id;
                $tb->section_id = $request->class_teacher_section_id;
            }
            if ($tb->save()) {
                if ($request->user_role == 'student') {
                    try{
                        // Fire event to store Student information
                        event(new StudentInfoUpdateRequested($request,$tb->id));
                    } catch(\Exception $ex) {
                        Log::info('id: '.$tb->id. 'err:'.$ex->getMessage());
                    }
                }
            }
        });

        return back()->with('status', '更改成功');
    }

    /**
     * Activate admin
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAdmin($id)
    {
        $admin = User::find($id);

        if ($admin->active !== 0) {
            $admin->active = 0;
        } else {
            $admin->active = 1;
        }

        $admin->save();

        return back()->with('status', '更改成功');
    }

    /**
     * Deactivate admin
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivateAdmin($id)
    {
       $admin = User::find($id);

        if ($admin->active !== 1) {
            $admin->active = 1;
            $admin->save();
            return back()->with('status', '啟用成功');
        }
        else {
            $admin->active = 0;
            $admin->save();
            return back()->with('status', '停權成功');
        } 
    }

    public function deactivateStudent(Request $request)
    {
        $student = User::find($request->id);

        if ($student->where('id', $request->id)->first()['school_id'] != \Auth::user()->school_id)
        {
            return back()->with('errorMsg', '權限不足');
        }

        if ($student->active !== 1) {
            $student->active = 1;
        }
        else {
            $student->active = 0;
        }

        $student->save();

        return back()->with('status', '更改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        // return (User::destroy($id))?response()->json([
      //   'status' => 'success'
      // ]):response()->json([
      //   'status' => 'error'
      // ]);
    }
}
