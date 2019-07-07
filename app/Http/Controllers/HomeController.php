<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\Myclass;
use App\Section;
use App\User;
use App\Department;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if(\Auth::user()->role == 'master') {
        $schools = School::all();
        $classes = Myclass::all();
        $sections = Section::all();
        $teachers = User::join('departments', 'departments.id', '=', 'users.department_id')
          ->where('role', 'teacher')
          ->orderBy('name','ASC')
          ->where('active', 1)
          ->get();
        $departments = Department::where('school_id',\Auth::user()->school_id)->get();
        return view('school.create-school', compact('schools', 'classes', 'sections', 'teachers', 'departments'));
      }
      else {

        $minutes = 1440;// 24 hours = 1440 minutes
        $school_id = \Auth::user()->school->id;

        $classes = \Cache::remember('classes-'.$school_id, $minutes, function () use($school_id) {
          return \App\Myclass::where('school_id', $school_id)
                            ->pluck('id')
                            ->toArray();
        });

        $totalStudents = \Cache::remember('totalStudents-'.$school_id, $minutes, function () use($school_id) {
          return \App\User::where('school_id',$school_id)
                          ->where('role','student')
                          ->where('active', 1)
                          ->count();
        });

        $totalTeachers = \Cache::remember('totalTeachers-'.$school_id, $minutes, function () use($school_id) {
          return \App\User::where('school_id',$school_id)
                          ->where('role','teacher')
                          ->where('active', 1)
                          ->count();
        });

        $totalBooks = \Cache::remember('totalBooks-'.$school_id, $minutes, function () use($school_id) {
          return \App\Book::where('school_id',$school_id)->count();
        });

        $totalClasses = \Cache::remember('totalClasses-'.$school_id, $minutes, function () use($school_id) {
          return \App\Myclass::where('school_id',$school_id)->count();
        });

        $totalSections = \Cache::remember('totalSections-'.$school_id, $minutes, function () use ($classes) {
          return \App\Section::whereIn('class_id', $classes)->count();
        });

        // 取得通知
        // $notices = \Cache::remember('notices-'.$school_id, $minutes, function () use($school_id) {
        //   return \App\Notice::where('school_id', $school_id)
        //                     ->where('active', 1)
        //                     ->take(5)
        //                     ->get();
        // });
        $notices = \App\Notice::where('school_id', $school_id)->where('active', 1)->orderBy('id', 'desc')->take(5)->get();

        // 取得事件
        // $events = \Cache::remember('events-'.$school_id, $minutes, function () use($school_id) {
        //   return \App\Event::where('school_id', $school_id)
        //                   ->where('active',1)
        //                   ->take(5)
        //                   ->get();
        // });
        $events = \App\Event::where('school_id', $school_id)->where('active', 1)->orderBy('id', 'desc')->take(5)->get();

        // 取得代辦事項
        // $routines = \Cache::remember('routines-'.$school_id, $minutes, function () use($school_id) {
        //   return \App\Routine::where('school_id', $school_id)
        //                     ->where('active',1)
        //                     ->take(5)
        //                     ->get();
        // });
        $routines = \App\Routine::where('school_id', $school_id)->where('active', 1)->orderBy('id', 'desc')->take(5)->get();

        // 取得課程大綱
        // $syllabuses = \Cache::remember('syllabuses-'.$school_id, $minutes, function () use($school_id) {
        //   return \App\Syllabus::where('school_id', $school_id)
        //                       ->where('active',1)
        //                       ->take(5)
        //                       ->get();
        // });
        $syllabuses = \App\Syllabus::where('school_id', $school_id)->where('active', 1)->orderBy('id', 'desc')->take(5)->get();

        // 取得考試
        // $exams = \Cache::remember('exams-'.$school_id, $minutes, function () use($school_id) {
        //   return \App\Exam::where('school_id', $school_id)
        //                   ->where('active',1)
        //                   ->get();
        // });
        $exams = \App\Exam::where('school_id', $school_id)->where('active', 1)->orderBy('id', 'desc')->get();

        // if(\Auth::user()->role == 'student')
        //   $messageCount = \App\Notification::where('student_id',\Auth::user()->id)->count();
        // else
        //   $messageCount = 0;

        return view('home',[
          'totalStudents'=>$totalStudents,
          'totalTeachers'=>$totalTeachers,
          'totalBooks'=>$totalBooks,
          'totalClasses'=>$totalClasses,
          'totalSections'=>$totalSections,
          'notices'=>$notices,
          'events'=>$events,
          'routines'=>$routines,
          'syllabuses'=>$syllabuses,
          'exams'=>$exams,
          //'messageCount'=>$messageCount,
        ]);
      }
    }
}
