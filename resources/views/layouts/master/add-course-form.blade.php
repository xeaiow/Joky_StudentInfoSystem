<a class="btn btn-xs btn-primary pull-right" data-toggle="collapse" href="#collapseForNewCourse{{$section->id}}" aria-expanded="false" aria-controls="collapseForNewCourse{{$section->id}}">新增課程</a>
  <div class="collapse" id="collapseForNewCourse{{$section->id}}" style="margin-top:1%;">
    <div class="panel panel-default">
      <div class="panel-body">
      <form class="form-horizontal" action="{{url('courses/store')}}" method="post">
          {{csrf_field()}}
          <input type="hidden" name="class_id" value="{{$class->id}}"/>
          <input type="hidden" name="section_id" value="{{$section->id}}"/>
          <div class="form-group">
            <label for="courseName{{$section->id}}" class="col-sm-2 control-label">課程名稱</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="courseName{{$section->id}}" name="course_name">
            </div>
          </div>
          <div class="form-group">
            <label for="teacherDepartment{{$section->id}}" class="col-sm-2 control-label">選擇教師類別</label>
            <div class="col-sm-10">
              <select class="form-control" id="teacherDepartment{{$section->id}}" name="teacher_department">
                <option value="0" selected disabled>請選擇</option>
                @if(count($departments) > 0)
                  {{$departments_of_this_school = $departments->filter(function ($department) use ($school){
                    return $department->school_id == $school->id;
                  })}}
                  @foreach ($departments_of_this_school as $d)
                    <option value="{{$d->department_name}}">{{$d->department_name}}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="assignTeacher{{$section->id}}" class="col-sm-2 control-label">選擇教師</label>
            <div class="col-sm-10">
              <select class="form-control" id="assignTeacher{{$section->id}}" name="teacher_id">
                <option value="0" selected disabled>請選擇</option>
                @if(count($teachers) > 0)
                  {{$teachers_of_this_school = $teachers->filter(function ($teacher) use ($school){
                    return $teacher->school_id == $school->id;
                  })}}
                  @foreach($teachers_of_this_school as $teacher)
                    <option value="{{$teacher->id}}" data-department="{{$teacher->department_name}}">{{$teacher->name}} {{$teacher->department_name}}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        <div class="form-group">
          <label for="course_type{{$section->id}}" class="col-sm-2 control-label">課程類型</label>
          <div class="col-sm-10">
            <select class="form-control" id="course_type{{$section->id}}" name="course_type">
              <option value="core">主修</option>
              <option value="elective">選修</option>
              <option value="optional">其他</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="courseTime{{$section->id}}" class="col-sm-2 control-label">課程時間</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="courseTime{{$section->id}}" name="course_time" placeholder="2019-08-01">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10 text-right">
            <button type="submit" class="btn btn-danger">新增</button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
<script>
  $('#teacherDepartment{{$section->id}}').click(function () {
    $("#assignTeacher{{$section->id}} option").hide();
    $("#assignTeacher{{$section->id}} option[data-department="+$(this).val()+"]").show();
  });
</script>
