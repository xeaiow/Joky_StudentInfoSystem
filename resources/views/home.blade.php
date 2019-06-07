@extends('layouts.app')
@section('title', '主控台')
@section('content')
<style>
    .badge-download {
        background-color: transparent !important;
        color: #464443 !important;
    }
    .list-group-item-text{
      font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default" style="border-top: 0px;">
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <!-- 當前考試 -->
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title">當前考試</div>
                                <div class="panel-body">
                                    @if(count($exams) > 0)
                                    <table class="table">
                                        <tr>
                                            <th>考試名稱</th>
                                            <th>考試公告已發佈</th>
                                            <th>考試結果已發佈</th>
                                        </tr>
                                        @foreach($exams as $exam)
                                        <tr>
                                            <td>{{$exam->exam_name}}</td>
                                            <td>{{($exam->notice_published === 1)?'是':'否'}}</td>
                                            <td>{{($exam->result_published === 1)?'是':'否'}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @else
                                    沒有資料
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- 當前考試_ -->
                        <!-- 資訊板 -->
                        <div class="col-sm-6">
                        <div class="panel panel-default">
                                <div class="page-panel-title">統計資料</div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <th>學生總數</th>
                                            <th>教師總數</th>
                                            <th>書籍種類</th>
                                            <th>課程總數</th>
                                            <th>科目總數</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $totalStudents }}</td>
                                            <td>{{ $totalTeachers }}</td>
                                            <td>{{ $totalBooks }}</td>
                                            <td>{{ $totalClasses }}</td>
                                            <td>{{ $totalSections }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- 資訊板_ -->
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title">通知</div>
                                <div class="panel-body pre-scrollable">
                                    @if(count($notices) > 0)
                                    <div class="list-group">
                                        @foreach($notices as $notice)
                                        <a href="{{url($notice->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                get_app
                                            </i>
                                            <h5 class="list-group-item-heading">{{$notice->title}}</h5>
                                            <p class="list-group-item-text">發佈於：
                                                {{$notice->created_at->format('M d Y h:i:sa')}}</p>
                                        </a>
                                        @endforeach
                                    </div>
                                    @else
                                    沒有資料
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title">事件</div>
                                <div class="panel-body pre-scrollable">
                                    @if(count($events) > 0)
                                    <div class="list-group">
                                        @foreach($events as $event)
                                        <a href="{{url($event->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                get_app
                                            </i>
                                            <h5 class="list-group-item-heading">{{$event->title}}</h5>
                                            <p class="list-group-item-text">發佈於：
                                                {{$event->created_at->format('M d Y')}}</p>
                                        </a>
                                        @endforeach
                                    </div>
                                    @else
                                    沒有資料
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title">待辦事項</div>
                                <div class="panel-body pre-scrollable">
                                    @if(count($routines) > 0)
                                    <div class="list-group">
                                        @foreach($routines as $routine)
                                        <a href="{{url($routine->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                get_app
                                            </i>
                                            <h5 class="list-group-item-heading">{{$routine->title}}</h5>
                                            <p class="list-group-item-text">發佈於：
                                                {{$routine->created_at->format('M d Y')}}</p>
                                        </a>
                                        @endforeach
                                    </div>
                                    @else
                                    沒有資料
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title">課程大綱</div>
                                <div class="panel-body pre-scrollable">
                                    @if(count($syllabuses) > 0)
                                    <div class="list-group">
                                        @foreach($syllabuses as $syllabus)
                                        <a href="{{url($syllabus->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                get_app
                                            </i>
                                            <h5 class="list-group-item-heading">{{$syllabus->title}}</h5>
                                            <p class="list-group-item-text">發佈於：
                                                {{$syllabus->created_at->format('M d Y')}}</p>
                                        </a>
                                        @endforeach
                                    </div>
                                    @else
                                    沒有資料
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
