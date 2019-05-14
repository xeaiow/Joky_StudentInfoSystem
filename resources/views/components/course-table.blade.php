<div class="table-responsive">
  <table class="table table-bordered table-striped table-data-div table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">課程名稱</th>
      <th scope="col">上課時段</th>
      <th scope="col">教室編號</th>
      @if($student)
        <th scope="col">授課教師</th>
      @endif
      @if(!$student)
        <th scope="col">班級編號</th>
        <th scope="col">課程編號</th>
        <th scope="col">所有學生</th>
        <th scope="col">點名</th>
      @endif
      @foreach ($courses as $course)
        @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
          <th scope="col">設定紀錄</th>
          <th scope="col">成績紀錄</th>
        @endif
        @break
      @endforeach
      @if(Auth::user()->role == 'admin')
        {{-- <th scope="col">操作</th>
        <th scope="col">操作</th> --}}
        <th scope="col">編輯</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($courses as $course)
    <tr>
      <th scope="row">{{($loop->index + 1)}}</th>
      <td>
        {{$course->course_name}}
      </td>

      <td><small>{{$course->course_time}}</small></td>

      <td>{{$course->section->room_number}}</td>

      @if($student)
        <td>
          <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
        </td>
      @endif

      @if(!$student)
        <td>{{$course->section->class->class_number}}</td>
        <td>{{$course->section->section_number}}</td>

        @if($course->exam_id != 0)
          <td>
            <a href="{{url('course/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-xs"><i class="material-icons">message</i> 推送訊息</a>
          </td>
        @else
          <td><small>Save under Exam to Add Student</small></td>
        @endif

        @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
          <td>
            <a href="{{url('attendances/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-primary btn-xs"><i class="material-icons">spellcheck</i> 點名</a>
          </td>
        @else
          <td><small>Save under Exam to Take Attendance</small></td>
        @endif

      @endif

      @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
        <td>
          <a href="{{url('grades/c/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-danger btn-xs"><i class="material-icons">assessment</i> 送出成績</a>
        </td>
        <td>
          <a href="{{url('grades/t/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-success btn-xs"><i class="material-icons">bar_chart</i> 查看</a>
        </td>
      @endif

      @if(Auth::user()->role == 'admin')

        {{-- @if($course->exam_id != 0)
        <td>
          <a role="button" class="btn btn-primary btn-xs pull-right" href="{{url('grades/c/store/'.$course->id.'/'.$course->exam_id.'/'.$course->teacher_id.'/'.$course->section->id)}}"><i class="material-icons">person_add</i> Add Students</a>
        </td>
        @else
          <td><small>Create Exam to Add Student</small></td>
        @endif

        @if(count($exams)>0)
          <td>
            <form action="{{url('courses/save-under-exam')}}" class="form-inline" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="course_id" value="{{$course->id}}">
            <select class="form-control input-sm" name="exam_id" autocomplete="off">
              @foreach($exams as $exam)
                <option value="{{$exam->id}}" {{($course->exam_id == $exam->id)?"selected":''}}>{{$exam->exam_name}}</option>
              @endforeach
            </select>
            <input type="submit" class="btn btn-success btn-xs" value="Save under selected exam"/>
            </form>
          </td>
        @else
          <td><small>No Exam Available</small></td>
        @endif --}}

        <td>
          <a href="{{url('edit/course/'.$course->id)}}" class="btn btn-xs btn-danger"><i class="material-icons">edit</i> 編輯</a>
        </td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
</div>