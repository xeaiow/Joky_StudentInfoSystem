<div class="form-group text-right">
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addClassModal{{$school->id}}">新增課程</button>
</div>

<!-- Modal -->
<div class="modal fade" id="addClassModal{{$school->id}}" tabindex="-1" role="dialog" aria-labelledby="addClassModal{{$school->id}}Label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">新增課程</h4>
      </div>
      <div class="modal-body">
      <form class="form-horizontal" action="{{url('school/add-class')}}" method="post">
          {{csrf_field()}}
          <div class="form-group">
            <label for="classNumber{{$school->id}}" class="col-sm-2 control-label">名稱</label>
            <div class="col-sm-10">
              <input type="text" name="class_number" class="form-control" id="classNumber{{$school->id}}" placeholder="會話一" required>
            </div>
          </div>
          <div class="form-group">
            <label for="classRoomNumber{{$school->id}}" class="col-sm-2 control-label">課程類別</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="group" id="classRoomNumber{{$school->id}}" placeholder="英語, 數學, 自然">
              <span id="helpBlock" class="help-block">*留空為則為無群組</span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12 text-right">
              <button type="submit" class="btn btn-primary btn-sm">新增</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">關閉</button>
      </div>
    </div>
  </div>
</div>
