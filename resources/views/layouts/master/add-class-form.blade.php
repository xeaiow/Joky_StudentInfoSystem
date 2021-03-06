<!-- Modal -->
<div class="modal fade" id="addClassModal{{ $school->id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">新增課程</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <form class="form-horizontal" action="{{ url('school/add-class') }}" method="post">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="classNumber{{ $school->id }}">名稱</label>
              <input type="text" name="class_number" class="form-control" id="classNumber{{$school->id}}" placeholder="英語會話" required>
          </div>
          <div class="form-group">
            <label for="classRoomNumber{{$school->id}}">課程類別</label>
            <select id="classRoomNumber{{ $school->id }}" name="group" class="form-control">
              @foreach($departments as $d)
                @if( $d->school_id == $school->id )
                  <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-primary btn-sm">新增</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
