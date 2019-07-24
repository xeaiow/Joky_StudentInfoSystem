<?php

namespace App\Http\Controllers;

use App\School;
use App\Myclass;
use App\Section;
use App\User;
use App\Department;
//use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $schools = School::all();
      $classes = Myclass::all();
      $sections = Section::all();
      $teachers = User::join('departments', 'departments.id', '=', 'users.department_id')
                            ->where('users.role', 'teacher')
                            ->orderBy('users.name','ASC')
                            ->where('users.active', 1)
                            ->select(['users.id AS userId', 'departments.id AS id', 'users.name AS name', 'users.email AS email', 'users.role AS role', 'users.active AS active', 'users.school_id AS school_id', 'users.code AS code', 'users.student_code AS student_code', 'users.gender AS gender', 'users.blood_group AS blood_groups', 'users.nationality AS nationality', 'users.phone_number AS phone_number', 'users.address AS address', 'users.about AS about', 'users.pic_path AS pic_path', 'users.verified AS verified', 'users.section_id AS section_id', 'users.created_at AS created_at', 'users.updated_at AS updated_at', 'users.department_id AS department_id', 'departments.department_name AS department_name'])
                            ->get();
      $departments = Department::where('school_id',\Auth::user()->school_id)->get();
      return view('school.create-school', compact('schools', 'classes', 'sections', 'teachers', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = [
        'school_name' => 'required|string|max:50',
        'school_medium' => 'required',
        'school_established' => 'required',
      ];
      $messages = [
        'required' => ':attribute必須填寫',
        'string' => ':attribute必須為合法字元',
        'school_name.max' => '機構名稱不得大於 50 個字元'
      ];

      $attributes = [
        'school_name' => '機構名稱',
        'school_medium' => '類型',
        'school_established' => '地址',
        'school_about' => '備註',
      ];

      $this->validate($request, $rules, $messages, $attributes);

      $tb = new School;
      $tb->name = $request->school_name;
      $tb->established = $request->school_established;
      $tb->about = (!empty($request->school_about)) ? $request->school_about : '';
      $tb->medium = $request->school_medium;
      $tb->code = date("y").substr(number_format(time() * mt_rand(),0,'',''),0,6);
      $tb->theme = 'flatly';
      $tb->save();
      return back()->with('status', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($school_id)
    {
      $admins = User::where('school_id',$school_id)->where('role','admin')->get();
      $school = School::where('id', $school_id)->first();
      return view('school.admin-list', compact('admins', 'school'));
    }

    // 整間停權
    public function deactivate ($school_id)
    {
      // 取得該學校現狀
      $school = School::where('id', $school_id);

      if ($school->first()['deactivate'] == 1)
      {
        $school->update(['deactivate' => 0]);
        // 停權該校學生
        User::where('school_id', $school_id)->update(['active' => 1]);
      }
      else {
        $school->update(['deactivate' => 1]);
        // 停權該校學生
        User::where('school_id', $school_id)->update(['active' => 0]);
      }

      
      return redirect('/create-school');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function addDepartment(Request $request){
      $attributes = [
        'department_name' => '類型名稱'
      ];
      $messages = [
        'required' => ':attribute必須填寫',
        'string' => ':attribute必須為字元',
        'max' => ':attribute不得超過 50 個字元'
      ];
      $rules = [
        'department_name' => 'required|string|max:50',
      ];
      $this->validate($request, $rules, $messages, $attributes);
      $s = new Department;
      $s->school_id = \Auth::user()->school_id;
      $s->department_name = $request->department_name;
      $s->save();
      return back()->with('status', '新增成功');
    }

    // 編輯類型名稱
    public function editDepartment(Request $request){
      $attributes = [
        'department_name' => '類型名稱'
      ];
      $messages = [
        'required' => ':attribute必須填寫',
        'string' => ':attribute必須為字元',
        'max' => ':attribute不得超過 50 個字元'
      ];
      $rules = [
        'department_name' => 'required|string|max:50',
      ];
      $this->validate($request, $rules, $messages, $attributes);

      Department::where('school_id', \Auth::user()->school_id)
      ->where('id', $request->department_id)
      ->update(['department_name' => $request->department_name]);

      return back()->with('status', '新增成功');
    }

    public function changeTheme(Request $request){
      $tb = School::find($request->s);
      $tb->theme = $request->school_theme;
      $tb->save();
      return back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $tb = School::find($id);
      $tb->name = $request->name;
      $tb->about = $request->about;
      //$tb->code = $request->code;
      return ($tb->save())?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // return (School::destroy($id))?response()->json([
      //   'status' => 'success'
      // ]):response()->json([
      //   'status' => 'error'
      // ]);
    }
}
