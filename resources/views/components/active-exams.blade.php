<div class="panel panel-default">
    <div class="page-panel-title" role="tab" id="heading{{$exam->id}}">
      <a class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$exam->id}}" aria-expanded="false" aria-controls="collapse{{$exam->id}}">
        <h5>
          {{$exam->exam_name}} <span class="pull-right"><small>查看適用本試卷的課程 <i class="material-icons">keyboard_arrow_down</i></small></span>
        </h5>
      </a>
    </div>
    <div id="collapse{{$exam->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$exam->id}}">
      <div class="panel-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
<<<<<<< HEAD
                    <th>課程名稱</th>
                    <th>課程類型</th>
                    <th>上課時間</th>
                    <th>授課教師</th>
=======
                    <th>教室</th>
                    <th>考試名稱</th>
                    <th>考試科目</th>
                    <th>考試時間</th>
                    <th>監考老師</th>
>>>>>>> aef31950fb71df21c686e10884dd57bd54aece5e
                </tr>
            </thead>
          <tbody>
            @foreach($courses as $course)
                @if($exam->id == $course->exam_id)
                <tr>
                    <td>{{$course->course_name}}</td>
                    <td>{{$course->course_type}}</td>
                    <td>{{$course->course_time}}</td>
                    <td>
                      <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
                    </td>
                </tr>
                @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
