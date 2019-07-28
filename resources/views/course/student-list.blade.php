@extends('layouts.app')

@section('title', '課程學員名單')

@section('content')

<style>
.dropdown-menu li a:hover, .notFoundCourse button:hover {
  color: #000 !important;
}
#course_lists {
  padding: 15px;
}
.focus, .dropCourse {
  cursor: pointer;
}
th {
  font-size: 16px !important;
}
</style>

<div class="container{{ (\Auth::user()->role == 'master')? '' : '-fluid' }}">
    <div class="row">
        @if(\Auth::user()->role != 'master')
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        @endif
        <div class="col-md-10" id="main-container">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
          <div class="card border-primary" style="margin-top: 20px;">
            <div class="card-header">學員當前課程</div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-data-div table-condensed table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">學號</th>
                    <th scope="col">姓名</th>
                    <th scope="col">頭像</th>
                    <th scope="col">性別</th>
                    <th scope="col">班級</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $student)
                    <tr>
                      <td>{{ $student->student_code }}</td>
                      <td>{{ $student->name }}</td>
                      <td><img src="{{ asset('01-progress.gif') }}" data-src="{{ url($student->pic) }}" style="border-radius: 50%;" width="25px" height="25px"></td>
                      <td>{{ ( $student->gender == 'male' ) ? '男' : '女' }}</td>
                      <td>{{ $student->course_name }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" rel="stylesheet" />
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
<script>

</script>
@endsection