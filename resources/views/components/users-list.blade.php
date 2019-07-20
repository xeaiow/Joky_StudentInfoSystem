{{ $users->links() }}
<style>
  th {
    font-size: 16px !important;
  }
</style>
<div class="table-responsive">
<table class="table table-bordered table-data-div table-condensed table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">學號</th>
      <th scope="col">姓名</th>
      <th scope="col">性別</th>
      @foreach ($users as $user)
        @if($user->role == 'student')
          <th scope="col">出勤狀況</th>
          @if (!Session::has('section-attendance'))
          <th scope="col">學年度</th>
          <th scope="col">學籍</th>
          <th scope="col">班級</th>
          <th scope="col">教室</th>
        @endif
        @elseif($user->role == 'teacher')
          @if (!Session::has('section-attendance'))
          <th scope="col">信箱</th>
          @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            <th scope="col">課程</th>
          @endif
          @endif
        @elseif($user->role == 'accountant' || $user->role == 'librarian')
          @if (!Session::has('section-attendance'))
          <th scope="col">電子信箱</th>
          @endif
        @endif
        @break($loop->first)
      @endforeach
      @if(Auth::user()->role == 'admin')
        @if (!Session::has('section-attendance'))
        <th scope="col">操作</th>
        @endif
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($users as $key=>$user)
    <tr>
      <td>{{$user->student_code}}</td>
      <td>
        <a href="{{ url('user/'.$user->student_code) }}">{{$user->name}}</a>
      </td>
      <td>
        @if(!empty($user->pic_path))
          <img src="{{ asset('01-progress.gif') }}" data-src="{{ url($user->pic_path) }}" style="border-radius: 50%;" width="25px" height="25px">
        @else
          @if(strtolower($user->gender) == 'male')
            <img src="{{ asset('01-progress.gif') }}" data-src="https://i.imgur.com/S8yYyrQ.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
          @else
            <img src="{{ asset('01-progress.gif') }}" data-src="https://i.imgur.com/nOgioLV.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
          @endif
        @endif
      </td>
      @if($user->role == 'student')
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
          <td ><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$user->id.'/0')}}">查看</a></td>
          {{--@if (!Session::has('section-attendance'))
          <td><a class="btn btn-xs btn-success" role="button" href="{{url('grades/'.$user->id)}}">查看</a></td>
          @endif --}}
        @endif
        @if (!Session::has('section-attendance'))
        <td>{{$user->studentInfo['session']}}</td>
        <td>{{ucfirst($user->studentInfo['version'])}}</td>
        <td>{{$user->section->class->class_number}} {{!empty($user->group)? '- '.$user->group:''}}</td>
        <td style="white-space: nowrap;">{{$user->section->section_number}}
          {{-- @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
            - <a class="btn btn-xs btn-primary" role="button" href="{{url('courses/0/'.$user->section->id)}}">All Courses</a>
          @endif --}}
          
        </td>
        @endif
      @elseif($user->role == 'teacher')
        @if (!Session::has('section-attendance'))
        <td>
          {{$user->email}}
        </td>
        @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
        <td style="white-space: nowrap;">
          <a href="{{url('courses/'.$user->id.'/0')}}">所有課程</a>
        </td>
        @endif
        @endif
      @elseif($user->role == 'accountant' || $user->role == 'librarian')
        @if (!Session::has('section-attendance'))
        <td>
          {{$user->email}}
        </td>
        @endif
      @endif
      @if(Auth::user()->role == 'admin')
        @if (!Session::has('section-attendance'))
        <td>
          <a class="btn btn-xs btn-primary" href="{{ url('edit/user/'.$user->id) }}">編輯</a>
          <a class="btn btn-xs btn-primary" href="{{ url('user/'.$user->student_code) }}">詳細</a>
        </td>
        @endif
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
</div>
{{$users->links()}}
