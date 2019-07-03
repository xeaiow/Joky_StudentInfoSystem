<button class="btn btn-primary btn-block" id="create-section-btn-class-{{$class->id}}">新增班級</button>
<br/>
<div class="panel panel-default" id="create-section-btn-panel-class-{{$class->id}}" style="display:none;">
  <div class="panel-body">
  <form class="form-horizontal" action="{{url('school/add-section')}}" method="post">
      {{csrf_field()}}
      <input type="hidden" name="class_id" value="{{$class->id}}"/>
      <div class="form-group">
        <label for="section_number{{$class->class_number}}" class="col-sm-2 control-label">班級</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="section_number{{$class->class_number}}" name="section_number" placeholder="A, B, C..">
        </div>
      </div>
      <div class="form-group">
        <label for="room_number{{$class->class_number}}" class="col-sm-2 control-label">教室</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" id="room_number{{$class->class_number}}" name="room_number" placeholder="302">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-1 col-sm-11 text-right">
          <button type="submit" class="btn btn-primary btn-sm">新增</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $("#create-section-btn-class-{{$class->id}}").click(function(){
    $("#create-section-btn-panel-class-{{$class->id}}").toggle();
  });
</script>
