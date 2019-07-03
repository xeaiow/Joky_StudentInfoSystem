<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gradesystem as Gradesystem;

class GradesystemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(){
      $gpas = Gradesystem::where('school_id', \Auth::user()->school_id)->get();
      return view('gpa.all',['gpas'=>$gpas]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      return view('gpa.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
      $rules = [
        'grade_system_name' => 'required|string|max:40',
        'point' => 'required',
        'grade' => 'required',
        'from_mark' => 'required',
        'to_mark' => 'required',
      ];
      $messages = [
        'grade_system_name.required' => '制度名稱必須填寫',
        'grade_system_name.string' => '制度名稱必須為文字',
        'grade_system_name.max' => '制度名稱最長為 40 個字元',
        'point.required' => '積分必須填寫',
        'grade.required' => '級分必須填寫',
        'from_mark.required' => '級分範圍最小值必須填寫',
        'to_mark.required' => '級分範圍最大值必須填寫'
      ];
      $this->validate($request, $rules, $messages);

      $gpa = new Gradesystem;
      $gpa->grade_system_name = $request->grade_system_name;
      $gpa->point = $request->point;
      $gpa->grade = $request->grade;
      $gpa->from_mark = $request->from_mark;
      $gpa->to_mark = $request->to_mark;
      $gpa->school_id = \Auth::user()->school_id;
      $gpa->user_id = \Auth::user()->id;
      $gpa->save();
      return back()->with('status', '新增成功');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){}
    /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
    */
    public function edit($id){}
      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
    public function update(Request $request, $id){}
      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
    public function destroy(Request $request){
      $gpa = Gradesystem::find($request->gpa_id);
      $gpa->delete();
      return back()->with('status', '刪除成功');
    }
}
