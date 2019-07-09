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
                            ->where('role', 'teacher')
                            ->orderBy('name','ASC')
                            ->where('active', 1)
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
        'school_about' => 'required',
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
        'school_about' => '描述',
      ];

      $this->validate($request, $rules, $messages, $attributes);

      $tb = new School;
      $tb->name = $request->school_name;
      $tb->established = $request->school_established;
      $tb->about = $request->school_about;
      $tb->medium = $request->school_medium;
      $tb->code = date("y").substr(number_format(time() * mt_rand(),0,'',''),0,6);
      $tb->theme = 'flatly';
      $tb->save();
      return back()->with('status', '新增完成');
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
        'department_name' => '教育類型名稱'
      ];
      $messages = [
        'required' => ':attribute必須填寫',
        'string' => ':attribute必須為字元',
        'max' => ':attribute不得超過 50 字元'
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
