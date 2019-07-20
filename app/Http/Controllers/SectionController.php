<?php

namespace App\Http\Controllers;

use App\Section as Section;
use App\Http\Resources\SectionResource;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
      $classes = \App\Myclass::where('school_id',\Auth::user()->school->id)
                  ->get();
      $classeIds = \App\Myclass::where('school_id',\Auth::user()->school->id)
                    ->pluck('id')
                    ->toArray();
      $sections = \App\Section::whereIn('class_id',$classeIds)
                  ->orderBy('section_number')
                  ->get();
      $exams = \App\ExamForClass::whereIn('class_id',$classeIds)
                  ->groupBy('class_id')
                  ->get();
      return view('school.sections',[
        'classes' => $classes,
        'sections' => $sections,
        'exams' => $exams
      ]);
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
        'section_number' => 'required',
        'room_number' => 'required|max:255',
        'class_id' => 'required|numeric',
      ];
      $messages = [
        'section_number.required' => '班級名稱必須填寫',
        'room_number.required' => '教室必須填寫',
        'room_number.numeric' => '教室只能為數字',
        'class_id.required' => '課程編號遺失',
        'class_id.numeric' => '課程編號不合法',
        'room_number.max' => '描述最多只能輸入 255 個字元'
      ];
      $this->validate($request, $rules, $messages);

      $tb = new Section;
      $tb->section_number = $request->section_number;
      $tb->room_number = $request->room_number;
      $tb->class_id = $request->class_id;
      $tb->save();
      return back()->with('status', '新增成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SectionResource(Section::find($id));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $tb = Section::find($id);
      $tb->section_number = $request->section_number;
      $tb->room_number = $request->room_number;
      $tb->class_id = $request->class_id;
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
      return (Section::destroy($id))?response()->json([
        'status' => 'success'
      ]):response()->json([
        'status' => 'error'
      ]);
    }
}
