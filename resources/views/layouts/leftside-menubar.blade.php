<script>
  $(document).ready(function () {
    $('.nav-item.active').removeClass('active');
    $('a[href="' + window.location.href + '"]').closest('li').closest('ul').closest('li').addClass('active');
    $('a[href="' + window.location.href + '"]').closest('li').addClass('active');
  });
</script>
<style>
  .nav-item.active {
    background-color: #fce8e6;
    font-weight: bold;
  }

  .nav-item.active a {
    color: #d93025;
  }

  .nav-link-text {
    padding-left: 10%;
  }

  #side-navbar ul>li>a {
    padding: 8px 15px;
  }
</style>
{{--@if(Auth::user()->role != 'master')
<ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link" href="{{url('user/'.Auth::user()->student_code)}}"><i class="material-icons">face</i> <span
        class="nav-link-text">Profile</span></a>
  </li>
</ul>
@endif--}}
<ul class="nav flex-column">
  <li class="nav-item active">
    <a class="nav-link" href="{{ url('home') }}"><i class="material-icons">computer</i> <span class="nav-link-text">主控台</span></a>
  </li>
  @if(Auth::user()->role == 'admin')
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">calendar_today</i> <span class="nav-link-text">出席狀況</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
    <ul class="dropdown-menu" style="width: 100%;">
      <li class="nav-item">
        <a class="dropdown-item" href="{{url('school/sections?att=1')}}"><i class="material-icons">contacts</i> <span
            class="nav-link-text">學生</span></a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('school/sections?course=1') }}"><i class="material-icons">nature_people</i> <span class="nav-link-text">班級</span></a>
  </li>
  @endif

  {{-- <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">contacts</i> <span class="nav-link-text">Users Lists</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
    <ul class="dropdown-menu" style="width: 100%;">
      @if(Auth::user()->role != 'student')
      <li class="nav-item">
        <a class="dropdown-item" href="{{url('users/'.Auth::user()->school->code.'/1/0')}}"><i class="material-icons">contacts</i>
          <span class="nav-link-text">Student List</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="{{url('users/'.Auth::user()->school->code.'/0/1')}}"><i class="material-icons">contacts</i>
          <span class="nav-link-text">Teacher List</span></a>
      </li>
      @endif
      @if(Auth::user()->role == 'admin')
      <li class="nav-item">
        <a class="dropdown-item" href="{{url('users/'.Auth::user()->school->code.'/accountant')}}"><i class="material-icons">account_balance_wallet</i>
          <span class="nav-link-text">Accountant List</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="{{url('users/'.Auth::user()->school->code.'/librarian')}}"><i class="material-icons">local_library</i>
          <span class="nav-link-text">Librarian List</span></a>
      </li>
      @endif
    </ul>
  </li> --}}
  @if(Auth::user()->role != 'student')
  <li class="nav-item">
    <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/1/0')}}"><i class="material-icons">face</i>
      <span class="nav-link-text">學生</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/0/1')}}"><i class="material-icons">person</i>
      <span class="nav-link-text">教師</span></a>
  </li>
  @endif
  @if(Auth::user()->role == 'admin')
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">ballot</i> <span class="nav-link-text">考試</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
    <ul class="dropdown-menu" style="width: 100%;">
      <!-- Dropdown menu links -->
      <li>
        <a class="dropdown-item" href="{{ url('exams/create') }}"><i class="material-icons">note_add</i> <span class="nav-link-text">新增考試</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('exams/active') }}"><i class="material-icons">developer_board</i> <span
            class="nav-link-text">當前考試</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('exams') }}"><i class="material-icons">settings</i> <span class="nav-link-text">管理考試</span></a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('grades/all-exams-grade') }}"><i class="material-icons">assignment</i> <span class="nav-link-text">成績</span></a>
  </li>
  <li class="nav-item" style="border-bottom: 1px solid #dbd8d8;"></li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('academic/routine') }}"><i class="material-icons">perm_contact_calendar</i> <span class="nav-link-text">課程日誌</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('academic/syllabus') }}"><i class="material-icons">vertical_split</i> <span class="nav-link-text">教學大綱</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('academic/notice') }}"><i class="material-icons">message</i> <span class="nav-link-text">通知</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('academic/event') }}"><i class="material-icons">event</i> <span class="nav-link-text">公告</span></a>
  </li>
  <li class="nav-item" style="border-bottom: 1px solid #dbd8d8;"></li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('create-school') }}"><i class="material-icons">settings</i> <span class="nav-link-text">設定</span></a>
  </li>
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">chrome_reader_mode</i> <span class="nav-link-text">成績管理</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
    <ul class="dropdown-menu" style="width: 100%;">
      <!-- Dropdown menu links -->
      <li>
        <a class="dropdown-item" href="{{ url('gpa/all-gpa') }}"><i class="material-icons">developer_board</i> <span
            class="nav-link-text">所有成績</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('gpa/create-gpa') }}"><i class="material-icons">note_add</i> <span class="nav-link-text">建立成績分級</span></a>
      </li>
    </ul>
  </li>
  @endif
  
  {{--@if(Auth::user()->role == 'admin')
  <li class="nav-item dropdown">
    <a role="button" href="#" class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
        class="material-icons">cloud_upload</i> <span class="nav-link-text">Manage Uploads</span> <i class="material-icons pull-right">keyboard_arrow_down</i></a>
    <ul class="dropdown-menu" style="width: 100%;">
      <!-- Dropdown menu links -->
      <li>
        <a class="dropdown-item" href="{{ url('academic/notice') }}"><i class="material-icons">developer_board</i>
          <span class="nav-link-text">Upload Notice</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('academic/event') }}"><i class="material-icons">developer_board</i> <span
            class="nav-link-text">Upload Event</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('academic/routine') }}"><i class="material-icons">developer_board</i>
          <span class="nav-link-text">Upload Routine</span></a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ url('academic/syllabus') }}"><i class="material-icons">developer_board</i>
          <span class="nav-link-text">Upload Syllabus</span></a>
      </li>
    </ul>
  </li>
  @endif--}}
  @if(Auth::user()->role == 'student')
  <li class="nav-item">
    <a class="nav-link active" href="{{ url('attendances/0/'.Auth::user()->id.'/0') }}"><i class="material-icons">date_range</i>
      <span class="nav-link-text">我的出席狀況</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('courses/0/'.Auth::user()->section_id) }}"><i class="material-icons">subject</i>
      <span class="nav-link-text">我的課程</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ url('grades/'.Auth::user()->id) }}"><i class="material-icons">bubble_chart</i> <span
        class="nav-link-text">我的考試成績</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#"><i class="material-icons">payment</i> <span class="nav-link-text">繳費記錄</span></a>
  </li>
  @endif
  @if(Auth::user()->role == 'teacher')
  <li class="nav-item">
    <a class="nav-link" href="{{ url('courses/'.Auth::user()->id.'/0') }}"><i class="material-icons">import_contacts</i>
      <span class="nav-link-text">課程日誌</span></a>
  </li>
  @endif
</ul>
