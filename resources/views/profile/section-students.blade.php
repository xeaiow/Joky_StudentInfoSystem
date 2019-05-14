@extends('layouts.app')

@section('title', 'Course Students')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <ol class="breadcrumb" style="margin-top: 3%;">
                @if(isset($_GET['grade']) && $_GET['grade'] == 1)
                    <li><a href="{{url('grades/all-exams-grade')}}" style="color:#3b80ef;">Grades</a></li>
                @else
                    <li><a href="{{url('school/sections?course=1')}}" style="color:#3b80ef;">查看課程資訊</a></li>
                @endif
                <li class="active">學生資訊</li>
            </ol>
            <h2>學生資訊</h2>
            <div class="panel panel-default">
              @if(count($students) > 0)
                <div class="panel-body">
                    <table class="table table-data-div table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">學號</th>
                            <th scope="col">姓名</th>
                            <th scope="col">歷史成績</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{($loop->index+1)}}</td>
                            <td>{{$student->student_code}}</td>
                            <td><a href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a></td>
                            <td><a class="btn btn-xs btn-success" role="button" href="{{url('grades/'.$student->id)}}">查看</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
              @else
                <div class="panel-body">
                    No Related Data Found.
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
