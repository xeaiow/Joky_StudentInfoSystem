{{$books->links()}}
<div class="table-responsive">
  <table class="table table-bordered table-data-div table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">書名</th>
        <th scope="col">書籍編號</th>
        <th scope="col">類型</th>
        <th scope="col">租借人</th>
        <th scope="col">租借人編號</th>
        <th scope="col">租借日期</th>
        <th scope="col">歸還日期</th>
        <th scope="col">操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach($books as $book)
      <tr>
        <td>{{($loop->index + 1)}}</td>
        <td>{{$book->title}}</td>
        <td>{{$book->book->book_code}}</td>
        <td>{{$book->type}}</td>
        <td>{{$book->name}}</td>
        <td>{{$book->student_code}}</td>
        <td>{{Carbon\Carbon::parse($book->issue_date)->format('d/m/Y')}}</td>
        <td>{{Carbon\Carbon::parse($book->return_date)->format('d/m/Y')}}</td>
        <td>
          <form action="{{url('library/save_as_returned')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="issue_id" value="{{$book->id}}">
            <input type="hidden" name="book_id" value="{{$book->book_id}}">
            <button class="btn btn-xs btn-success">歸還</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
{{$books->links()}}
