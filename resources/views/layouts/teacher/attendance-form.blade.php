
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('attendance/take-attendance')}}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="section_id" value="{{$section_id}}">
      <input type="hidden" name="exam_id" value="{{$exam_id}}">
    <div class="table-responsive">
    <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">學號</th>
        <th scope="col">姓名</th>
        <th scope="col">出席</th>
        <th scope="col">出席次數</th>
        <th scope="col">請假次數</th>
        <th scope="col">缺席次數</th>
        <th scope="col">點名單紀錄</th>
      </tr>
    </thead>
    <tbody>
      @if (count($attendances) > 0)
        <input type="hidden" name="update" value="1">
        
        @foreach ($students as $student)
          <input type="hidden" name="students[]" value="{{$student->id}}">
        @endforeach
        @foreach ($attendances as $attendance)
        <tr>
          <th scope="row">{{($loop->index + 1)}}</th>
          <td>{{$attendance->student->student_code}}</td>
          <td>
            @if($attendance->present === 1)
              <span class="label label-success attdState">出席</span>
            @elseif($attendance->present === 2)
              <span class="label label-warning attdState">翹課</span>
            @else
              <span class="label label-danger attdState">缺席</span>
            @endif
            <a href="{{url('user/'.$attendance->student->student_code)}}">{{$attendance->student->name}}</a>
          </td>
          <td>
            <input type="hidden" name="attendances[]" value="{{$attendance->id}}">
            @if($attendance->present === 1)
              <div class="form-check">
                <input class="form-check-input position-static" type="checkbox" aria-label="Present" name="isPresent{{$loop->index}}" checked>
              </div>
            @else
            <div class="form-check">
              <input class="form-check-input position-static" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Absent">
            </div>
            @endif
          </td>
          @if(count($attCount) > 0)
            @foreach ($attCount as $at)
              @if($at->student_id == $attendance->student->id)
                <td>{{$at->totalPresent}}</td>
                <td>{{$at->totalAbsent}}</td>
                <td>{{$at->totalEscaped}}</td>
              @else
                @continue
              @endif
            @endforeach
          @else
            <td>0</td>
            <td>0</td>
            <td>0</td>
          @endif
          <td><a href="{{url('attendance/adjust/'.$attendance->student->id)}}" role="button" class="btn btn-danger btn-sm">查看</a></td>
        </tr>
        @endforeach
      @else
        <input type="hidden" name="update" value="0">
        <input type="hidden" name="attendances[]" value="0">
        @foreach ($students as $student)
        <input type="hidden" name="students[]" value="{{$student->id}}">
        <tr>
          <th scope="row">{{($loop->index + 1)}}</th>
          <td>{{$student->student_code}}</td>
          <td><span class="label label-success attdState">Present</span> {{$student->name}}</td>
          <td>
            <div class="form-check">
              <input class="form-check-input position-static" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Present" checked>
            </div>
          </td>
          @if(count($attCount) > 0)
            @foreach ($attCount as $at)
              @if($at->student_id == $student->id)
                <td>{{$at->totalPresent}}</td>
                <td>{{$at->totalAbsent}}</td>
                <td>{{$at->totalEscaped}}</td>
              @else
                @continue
              @endif
            @endforeach
          @else
            <td>0</td>
            <td>0</td>
            <td>0</td>
          @endif
          <td><a href="{{url('attendance/adjust/'.$student->id)}}" role="button" class="btn btn-danger btn-sm">查看或更改</a></td>
        </tr>
        @endforeach
      @endif
    </tbody>
  </table>
  </div>
  <div style="text-align:center;">
    @if (count($attendances) > 0)
      <button type="submit" class="btn btn-primary">更新</button>
    @else
      <button type="submit" class="btn btn-primary">更新</button>
    @endif
  </div>
</form>
<script>
  $('input[type="checkbox"]').change(function() {
      var attdState = $(this).parent().parent().parent().find('.attdState').removeClass('label-danger label-success');
      if($(this).is(':checked')){
        attdState.addClass('label-success').text('出席');
      } else {
        attdState.addClass('label-danger').text('請假');
      }
  });
</script>