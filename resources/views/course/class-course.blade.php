@extends('layouts.app')

@section('title', '所有課程')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            @if(Auth::user()->role != 'student')
            <ol class="breadcrumb" style="margin-top: 3%;">
                <li><a href="{{url('school/sections?course=1')}}" style="color:#3b80ef;">所有課程與班級</a></li>
                <li class="active">課程列表</li>
            </ol>
            @endif
            <div class="panel panel-default">
              @if(count($courses) > 0)
                @foreach ($courses as $course)
                    <div class="page-panel-title">
                        課程類型：{{$course->section->class->class_number}} - {{$course->section->section_number}}
                    </div>
                    @break($loop->first)
                @endforeach
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.course-table',['courses'=>$courses, 'exams'=>$exams, 'student'=>(Auth::user()->role == 'student')?true:false])
                    @endcomponent
                </div>
              @else
                <div class="panel-body">
                    沒有相關課程
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
