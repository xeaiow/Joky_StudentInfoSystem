<?php

namespace App\Http\Controllers;

use App\Section as Section;
use App\User;
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
        'room_number' => 'max:255',
        'class_id' => 'required|numeric',
      ];
      $messages = [
        'section_number.required' => '課程類型名稱必須填寫',
        'class_id.required' => '資料遺失',
        'class_id.numeric' => '資料不合法',
        'room_number.max' => '描述最多只能輸入 255 個字元'
      ];
      $this->validate($request, $rules, $messages);

      $tb = new Section;
      $tb->section_number = $request->section_number;
      $tb->room_number = ( empty($request->room_number) ) ? '' : $request->room_number;
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

    // 由 department id 取得旗下老師名單
    public function getTeacher (Request $req)
    {
      return User::where('department_id', $req->department)
      ->orderBy('name', 'asc')
      ->get(['id', 'name']);
    }
}
