<style>
  th {
    font-size: 16px !important;
  }
</style>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-data-div table-hover">
  <thead>
    <tr>
      <th scope="col">課程名稱</th>
      <th scope="col">上課時段</th>
      <th scope="col">描述</th>
      @if($student)
        <th scope="col">授課教師</th>
      @endif
      @if(!$student)
        <th scope="col">學生資料</th>
        <th scope="col">點名紀錄</th>
      @endif
      @foreach ($courses as $course)
        @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
          <th scope="col">設定紀錄</th>
          <th scope="col">成績紀錄</th>
        @endif
        @break
      @endforeach
      @if(Auth::user()->role == 'admin')
        <th scope="col">操作</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($courses as $course)
    <tr>
      <td>{{$course->course_name}}</td>
      <td>{{$course->course_time}}</td>
      <td>{{$course->section->room_number}}</td>
      @if($student)
        <td>
          <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
        </td>
      @endif
      @if(!$student)

          <td>
            <a href="{{url('course/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-xs"><i class="material-icons">message</i> 推送訊息</a>
          </td>
        @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin'))
          <td>
            <a href="{{url('attendances/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-primary btn-xs"><i class="material-icons">spellcheck</i> 點名</a>
          </td>
        @else
          <td>尚無資料</td>
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
        <td>
          <a href="{{url('edit/course/'.$course->id)}}" class="btn btn-xs btn-danger"><i class="material-icons">edit</i> 編輯</a>
        </td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
</div>