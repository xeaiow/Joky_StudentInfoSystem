@extends('layouts.app')

@section('title', 'Grade')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
          @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{url('courses/save-configuration')}}" method="POST">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$course_id}}">
            <div class="panel panel-default" id="main-container">
              @if(count($grades) > 0)
              @foreach ($grades as $grade)
                <div class="page-panel-title" style="font-size: 15px;"><b>課程</b>：{{$grade->course->course_name}} &nbsp; <b>教室</b>：{{$grade->course->section->class->class_number}} &nbsp;<b>班級</b>：{{$grade->course->section->section_number}}
                  <button type="submit" class="btn btn-success btn-xs pull-right">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 儲存
                  </button>
                </div>
                @break($loop->first)
              @endforeach
                <div class="panel-body" style="padding-top: 0px;">
                  <div class="alert alert-info alert-dismissible" style="font-size:13px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                      <li>
                        Select which Grade System you want to use.
                      </li>
                      <li>
                        <b>Count Example:</b> If you take 3 Quizes and want to count best 2, then Quiz Count is 2.
                      </li>
                      <li>
                        <b>Percentage Example:</b> Total percentage must be 100%. You can put 100% to a field or distribute it according to your need. Full mark is also needed for Percentage to work.
                      </li>
                      <li>
                        <b>Full Mark Example:</b> If you take a Class Test where full mark is 15, then Full mark for Class Test is 15.
                      </li>
                    </ul>
                  </div>
                      <table class="table table-condensed table-hover">
                        <thead>
                          <tr>
                            <th scope="col" style="width:10%;">選擇成績系統</th>
                            <th scope="col" style="width:10%;">小考次數</th>
                            <th scope="col" style="width:10%;">作業次數</th>
                            <th scope="col" style="width:10%;">課堂小考次數</th>
                            <th scope="col" style="width:10%;">出席率佔比</th>
                            <th scope="col" style="width:10%;">作業佔比</th>
                            <th scope="col" style="width:10%;">小考佔比</th>
                            <th scope="col" style="width:10%;">課堂測驗佔比</th>
                          </tr>
                        </thead>
                        <?php
                          $section_id = 0;
                        ?>
                        @foreach ($grades as $grade)
                        <tbody>
                          <tr>
                            <td>
                              <select class="form-control input-sm" name="grade_system_name">
                                @foreach($gradesystems as $gs)
                              <option {{($grade->course->grade_system_name == $gs->grade_system_name)?'selected=selected':''}}>{{$gs->grade_system_name}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                            <input type="number" class="form-control input-sm" id="quiz-count" name="quiz_count" placeholder="Quiz Count" max="5" value="{{$grade->course->quiz_count}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="assignment-count" name="assignment_count" placeholder="Assignment Count" max="3" value="{{$grade->course->assignment_count}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="ct-count" name="ct_count" placeholder="CT Count" max="5" value="{{$grade->course->ct_count}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="attendance" name="attendance_percent" placeholder="Percentage" max="50" value="{{$grade->course->attendance_percent}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="assignment" name="assignment_percent"
                              placeholder="Percentage" max="50" value="{{$grade->course->assignment_percent}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="quiz" name="quiz_percent" placeholder="Percentage" max="50" value="{{$grade->course->quiz_percent}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="class-test" name="ct_percent" placeholder="Percentage" max="50" value="{{$grade->course->ct_percent}}">
                            </td>
                          </tr>
                          <tr>
                            <th scope="col" style="width:10%;">期末考佔比</th>
                            <th scope="col" style="width:10%;">實作佔比</th>
                            <th scope="col" style="width:10%;">
                              課堂小考滿分為
                            </th>
                            <th scope="col" style="width:10%;">
                              Assignment Full Marks
                            </th>
                            <th scope="col" style="width:10%;">
                              CT Full Marks
                            </th>
                            <th scope="col" style="width:10%;">
                              期末考滿分為
                            </th>
                            <th scope="col" style="width:10%;">
                              實習課滿分為
                            </th>
                            <th scope="col" style="width:10%;">
                              出勤滿分為
                            </th>
                          </tr>
                          <tr>
                            <td>
                              <input type="number" class="form-control input-sm" id="final" name="final_exam_percent" placeholder="Percentage" max="100" value="{{$grade->course->final_exam_percent}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="practical_percent" name="practical_percent" placeholder="Percentage" max="100" value="{{$grade->course->practical_percent}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="q_full" name="quiz_fullmark" placeholder="Quiz Full Marks" max="20" value="{{$grade->course->quiz_fullmark}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="a_full" name="a_fullmark" placeholder="Assignment Full Marks" max="20" value="{{$grade->course->a_fullmark}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="ct_full" name="ct_fullmark" placeholder="CT Full Marks" max="20" value="{{$grade->course->ct_fullmark}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="final_full" name="final_fullmark" placeholder="Final Full Marks" max="100" value="{{$grade->course->final_fullmark}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="practical_full" name="practical_fullmark" placeholder="Practical Full Marks" max="100" value="{{$grade->course->practical_fullmark}}">
                            </td>
                            <td>
                              <input type="number" class="form-control input-sm" id="att_full" name="att_fullmark" placeholder="Attendance Full Marks" max="100" value="{{$grade->course->att_fullmark}}">
                            </td>
                          </tr>
                        </tbody>
                          <?php
                            $section_id = $grade->course->section->id;
                          ?>
                          @break($loop->first)
                        @endforeach
                      </table>
                </div>
              @else
                <div class="panel-body">
                  No Related Data Found.
                </div>
              @endif
            </div>
          </form>
            <div class="panel panel-default">
              @if(count($grades) > 0)
              <div class="page-panel-title" style="font-size: 15px;">
                <form action="{{url('grades/calculate-marks')}}" method="POST">
                  {{csrf_field()}}
                  登記成績
                  <input type="hidden" name="course_id" value="{{$course_id}}">
                  @foreach($gradesystems as $gs)
                    <input type="hidden" name="grade_system_name" value="{{$gs->grade_system_name}}">
                  @endforeach
                  <input type="hidden" name="exam_id" value="{{$exam_id}}">
                  <input type="hidden" name="teacher_id" value="{{$teacher_id}}">
                  <button type="submit" class="btn btn-info btn-xs pull-right">
                    <span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> Get Total Marks
                  </button>
                </form>
              </div>
              <div class="panel-body">
                @include('layouts.teacher.grade-form')
              </div>
              @else
                <div class="panel-body">
                  沒有找到資料
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
