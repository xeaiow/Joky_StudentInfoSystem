@extends('layouts.app')

@section('title', '課程')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <h2>所有授課課程</h2>
            <div class="panel panel-default">
              @if(count($courses) > 0)
              @foreach ($courses as $course)
                <div class="page-panel-title" style="font-size: 20px;"><b>教師編號：</b>{{$course->teacher->student_code}} <br /><b>教師名稱</b> - <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></div>
                 @break($loop->first)
              @endforeach
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>false])
                    @endcomponent
                </div>
              @else
                <div class="panel-body">
                    沒有找到資料
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
