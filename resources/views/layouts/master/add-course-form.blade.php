
  <div class="collapse" id="collapseForNewCourse{{ $section->id }}" style="margin-top:1%;">
    <div class="card border-primary mb-3">
      <div class="card-header text-center">新增課程</div>
      <div class="card-body">
      <form class="form-horizontal" action="{{ url('courses/store') }}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="class_id" value="{{ $class->id }}"/>
        <input type="hidden" name="section_id" value="{{ $section->id }}"/>
        <div class="form-group">
          <label for="courseName{{ $section->id }}">名稱</label>
          <input type="text" class="form-control" id="courseName{{ $section->id }}" name="course_name">
        </div>
        <div class="form-group">
          <label for="teacherDepartment{{ $section->id }}">教師類別</label>
          <select class="form-control" id="teacherDepartment{{ $section->id }}" name="teacher_department">
            <option value="0" selected disabled>請選擇</option>
            @if(count($departments) > 0)
              {{ $departments_of_this_school = $departments->filter(function ($department) use ($school){
                return $department->school_id == $school->id;
              }) }}
              @foreach ($departments_of_this_school as $d)
                <option value="{{$d->department_name}}">{{$d->department_name}}</option>
              @endforeach
            @endif
          </select>
        </div>
        <div class="form-group">
          <label for="assignTeacher{{ $section->id }}">教師</label>
            <select class="form-control" id="assignTeacher{{ $section->id }}" name="teacher_id">
              <option value="0" selected disabled>請選擇</option>
              @if(count($teachers) > 0)
                {{ $teachers_of_this_school = $teachers->filter(function ($teacher) use ($school){
                  return $teacher->school_id == $school->id;
                }) }}
                @foreach($teachers_of_this_school as $teacher)
                  <option value="{{ $teacher->userId }}" data-department="{{ $teacher->department_name }}">{{ $teacher->name }}</option>
                @endforeach
              @endif
            </select>
        </div>
        <div class="form-group">
          <label for="courseTime{{ $section->id }}">上課時段</label>
          <input type="time" class="form-control" id="courseTime{{ $section->id }}" name="course_time">
        </div>
        <div class="form-group">
          <div class="text-right">
            <button type="submit" class="btn btn-primary">新增</button>
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
