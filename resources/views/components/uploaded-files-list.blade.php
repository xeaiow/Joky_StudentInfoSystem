<div class="table-responsive">
  <table class="table table-bordered table-data-div table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">檔案名稱</th>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <th scope="col">Class</th>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <th scope="col">課程</th>
        @endif
        <th scope="col">已啟用</th>
        <th scope="col">操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach($files as $file)
      <tr>
        <td>{{($loop->index + 1)}}</td>
        <td><a href="{{url($file->file_path)}}" target="_blank">{{$file->title}}</a></td>
        @if($upload_type == 'syllabus' && $parent == 'class')
          <td>{{$file->myclass->class_number}}</td>
        @elseif($upload_type == 'routine' && $parent == 'section')
          <td>{{$file->section->section_number}}</td>
        @endif
        <td>{{($file->active === 1)?'是':'否'}}</td>
        <td>
          <a href="{{url('academic/remove/'.$upload_type.'/'.$file->id)}}" class="btn btn-danger btn-sm" role="button"><i class="material-icons">delete</i> 刪除</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
