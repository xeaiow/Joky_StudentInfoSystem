<?php

namespace App\Http\Controllers;

use App\Course;
use App\StudentCourse;
use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Http\Requests\Course\SaveConfigurationRequest;
use App\Http\Traits\GradeTrait;
use App\Http\Controllers\Course\HandleCourse;

class CourseController extends Controller
{
    use GradeTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teacher_id, $section_id){
      if(\Auth::user()->role != 'student' && $teacher_id > 0) {
        $courses = HandleCourse::getCoursesByTeacher($teacher_id);
        $exams = \App\Exam::where('school_id', \Auth::user()->school_id)
                          ->where('active',1)
                          ->get();
        $view = 'course.teacher-course';

      } else if(\Auth::user()->role == 'student'
                && $section_id == \Auth::user()->section_id
                && $section_id > 0) {
        $courses = HandleCourse::getCoursesBySection($section_id);
        $view = 'course.class-course';
        $exams = [];

      } else if(\Auth::user()->role != 'student' && $section_id > 0) {
        $courses = HandleCourse::getCoursesBySection($section_id);
        $exams = \App\Exam::where('school_id', \Auth::user()->school_id)
                          ->where('active',1)
                          ->get();
        $view = 'course.class-course';
      } else {
        return redirect('home');
      }
      return view($view,['courses'=>$courses,'exams'=>$exams]);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function course($teacher_id,$course_id,$exam_id,$section_id)
    {
      $this->addStudentsToCourse($teacher_id,$course_id,$exam_id,$section_id);
      $students = HandleCourse::getStudentsFromGradeByCourseAndExam($course_id, $exam_id);
      return view('course.students', [
        'students'=>$students,
        'teacher_id'=>$teacher_id,
        'section_id'=>$section_id,
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try{
        HandleCourse::addCourse($request);
      } catch (\Exception $ex){
        return back()->with('errorMsg', '新增失敗');
      }
      return back()->with('status', '新增成功');
    }

    /**
     * @param SaveConfigurationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveConfiguration(SaveConfigurationRequest $request){
      try{
        HandleCourse::saveConfiguration($request);
      } catch (\Exception $ex){
        return 'Could not save configuration.';
      }
      return back()->with('status', '儲存成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return new CourseResource(Course::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $course = Course::find($id);
      return view('course.edit', ['course'=>$course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateNameAndTime(Request $request, $id)
    {
      $attributes = [
        'course_name' => '課程名稱',
        'course_time' => '上課時段'
      ];

      $rules = [
        'course_name' => 'required|string',
        'course_time' => 'required|string'
      ];
      
      $messages = [
        'required' => ':attribute必須填寫',
        'string' => ':attribute必須為合法字元'
      ];

      $this->validate($request, $rules, $messages, $attributes);

      $tb = Course::find($id);
      $tb->course_name = $request->course_name;
      $tb->course_time = $request->course_time;
      $tb->save();
      return back()->with('status', '更改成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      return (Course::destroy($id))?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }

    // 加退選課程頁面
    public function addAndDropCourse(Request $req)
    {
      $currentCourse = StudentCourse::join('courses', 'student_courses.course_id', '=', 'courses.id')
      ->select('student_courses.*', 'courses.course_name', 'courses.id AS courseId')
      ->where('student_id', $req->student_id)
      ->get();
      return view('course.add-drop-course', ['courses' => $currentCourse, 'student_id' => $req->student_id]);
    }


    // 用關鍵字取得課程列表
    public function keywordGetCourse (Request $req)
    {
      $keyword = $req->course_name;
      return Course::
      join('classes', 'classes.id', '=', 'courses.class_id')
      ->where('classes.school_id', \Auth::user()->school_id)
      ->where('course_name', 'like', $keyword.'%')
      ->get();
    }

    // 用關鍵字取得課程列表
    public function getCourse (Request $req)
    {
      $keyword = $req->course_name;
      return Course::
      join('users', 'users.id', '=', 'courses.teacher_id')
      ->join('classes', 'classes.id', '=', 'courses.class_id')
      ->select('courses.id', 'courses.course_name', 'courses.course_time', 'users.name')
      ->where('classes.school_id', \Auth::user()->school_id)
      ->where('course_name', $keyword)
      ->get();
    }

    // 加選課程
    public function addCourse (Request $req)
    {
      $exists = StudentCourse::where('student_id', $req->student_id)
      ->where('course_id', $req->course_id)->count();

      if ($exists == 0)
      {
        $data = [
          'student_id' => $req->student_id,
          'course_id' => $req->course_id
        ];
        $response['result'] = StudentCourse::create($data);
        $response['status'] = true;
        return $response;
      }
      else {
        $response['status'] = false;
        return $response;
      }
    }

    // 退選課程
    public function dropCourse (Request $req)
    {
      $course = StudentCourse::where('student_id', $req->student_id)
      ->where('course_id', $req->course_id);

      if ($course->count() > 0)
      {
        $course->delete();
        $response['status'] = true;
        return $response;
      }
      else {
        $response['status'] = false;
        return $response;
      }
    }

    // 取得課程學員
    public function getCourseStudent(Request $req)
    {
        $course_id = $req->course_id;
        $studentList = StudentCourse::join('users', 'users.student_code', '=', 'student_courses.student_id')
        ->join('courses', 'courses.id', '=', 'student_courses.course_id')
        ->where('course_id', $course_id)
        ->get(['users.student_code', 'users.name', 'users.pic_path AS pic', 'users.id AS id', 'users.gender', 'student_courses.course_id', 'courses.course_name']);
        return view('course.student-list', ['students' => $studentList]);
    }
}
