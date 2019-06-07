{{$exams->links()}}
<div class="table-responsive">
  @foreach ($exams as $exam)
    <form id="form{{$exam->id}}" action="{{url('exams/activate-exam')}}" method="POST">
      {{csrf_field()}}
    </form>
  @endforeach
  <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">考試卷名稱</th>
      <th scope="col">發佈公告</th>
      <th scope="col">發佈結果</th>
      <th scope="col">建立時間</th>
      <th scope="col">啟用</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($exams as $exam)
    <tr>
      <td scope="row">{{$exam->exam_name}}</td>
      <td scope="row">
        @if($exam->notice_published === 1)
          是
        @else
          @if($exam->result_published === 1)
            否
          @else
            <span class="label label-danger checkbox-inline">
              <input type="checkbox" name="notice_published" form="form{{$exam->id}}" /> 是
            </span>
          @endif
        @endif
      </td>
      <td scope="row">
        @if($exam->result_published === 1)
          是
        @else
          <span class="label label-danger checkbox-inline">
            <input type="checkbox" name="result_published" form="form{{$exam->id}}" /> 是
          </span>
        @endif
      </td>
      <td scope="row">{{Carbon\Carbon::parse($exam->created_at)->format('Y/m/d')}}</td>
      <td scope="row">
        <input type="hidden" name="exam_id" value="{{$exam->id}}" form="form{{$exam->id}}"/>
        @if($exam->active === 1)
          <span class="label label-success checkbox-inline">
            <input type="checkbox" name="active" form="form{{$exam->id}}" checked />
              啟用
          </span>
        @else
          @if($exam->result_published === 1)
            已完成
          @else
            <span class="label label-danger checkbox-inline">
              <input type="checkbox" name="active" form="form{{$exam->id}}" />
              停用
            </span>
          @endif
        @endif
        @if($exam->result_published != 1)
          <input type="submit" class="btn btn-info btn-xs" style="margin-left: 1%;" value="儲存" form="form{{$exam->id}}"/>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
{{$exams->links()}}
