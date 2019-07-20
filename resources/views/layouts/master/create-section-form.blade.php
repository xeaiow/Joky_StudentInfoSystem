<div class="card border-primary mb-3">
  <div class="card-header text-center">新增課程類型</div>
  <div class="card-body">
    <form class="form-horizontal" action="{{ url('school/add-section') }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="class_id" value="{{ $class->id }}"/>
      <div class="form-group">
        <label for="section_number{{ $class->class_number }}">名稱</label>
        <input type="text" class="form-control" id="section_number{{ $class->class_number }}" name="section_number">
      </div>
      <div class="form-group">
        <label for="room_number{{ $class->class_number }}">描述</label>
        <input type="text" class="form-control" id="room_number{{ $class->class_number }}" name="room_number">
      </div>
      <div class="form-group">
        <div class="text-right">
          <button type="submit" class="btn btn-primary">新增</button>
        </div>
      </div>
    </form>
  </div>
</div>
