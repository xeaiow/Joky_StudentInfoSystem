@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <ol class="breadcrumb" style="margin-top: 3%;">
                <li><a href="{{url('school/sections?att=1')}}" style="color:#3b80ef;">所有課程出席狀況</a></li>
                <li class="active">出席</li>
            </ol>
            <h2>送出點名表</h2>
            <div class="panel panel-default">
                @if(count($students) > 0)
                @foreach ($students as $student)
                  <div class="page-panel-title">
                    <b>課程</b>: {{ $student->section->section_number}} &nbsp; <b>教室</b>：最近更新: {{$student->section->class->class_number}}
                    <span class="pull-right"><b>最近更新：</b> &nbsp;{{ Carbon\Carbon::now()->format('Y/m/d h:i A')}}</span>
                  </div>
                   @break($loop->first)
                @endforeach
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('layouts.teacher.attendance-form')
                </div>
                @else
                <div class="panel-body">
                    沒有資料
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
