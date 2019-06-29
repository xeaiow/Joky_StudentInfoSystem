@extends('layouts.app')
@section('title', '主控台')
@section('content')
<style>
    .badge-download {
        background-color: transparent !important;
        color: #464443 !important;
    }
    .list-group-item-text{
      font-size: 14px;
    }
    .focus:hover {
        cursor: pointer;
    }
    .panel-default {
        border-color: #FFFFFF !important;
    }
    .important-text {
        font-weight: 900;
    }
    .table tr th, .table tr td {
        font-size: 16px !important;   
    }
    .page-panel-title {
        font-size: 24px !important;
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
                        <div class="col-sm-2">
                            <div class="card bg-dark text-white">
                                <div class="card-header">
                                    學生人數：{{ $totalStudents }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card bg-dark text-white">
                                <div class="card-header">
                                    教師人數：{{ $totalTeachers }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card bg-info text-white">
                                <div class="card-header">
                                    科目總數：{{ $totalSections }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card bg-info text-white">
                                <div class="card-header">
                                    課程總數：{{ $totalClasses }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="card bg-info text-white">
                                <div class="card-header">
                                    書籍總數：{{ $totalBooks }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <!-- 當前考試 -->
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="page-panel-title important-text">當前考試</div>
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
                       
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title important-text">通知</div>
                                <div class="panel-body">
                                    @if(count($notices) > 0)
                                    <div class="list-group">
                                        @foreach($notices as $notice)
                                        <a href="{{url($notice->file_path)}}" class="list-group-item">
                                            <i class="badge badge-download material-icons">
                                                keyboard_arrow_right
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
                                    <a href="{{ URL::to('academic/notice') }}"><span class="badge badge-pill badge-dark focus">查看更多..</span></a>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title important-text">公告</div>
                                <div class="panel-body">
                                    @if(count($events) > 0)
                                    <div class="list-group">
                                        @foreach($events as $event)
                                        <a href="{{url($event->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                keyboard_arrow_right
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
                                    <a href="{{ URL::to('academic/event') }}"><span class="badge badge-pill badge-dark focus">查看更多..</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title important-text">待辦事項</div>
                                <div class="panel-body">
                                    @if(count($routines) > 0)
                                    <div class="list-group">
                                        @foreach($routines as $routine)
                                        <a href="{{url($routine->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                keyboard_arrow_right
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
                                     <a href="{{ URL::to('academic/routine') }}"><span class="badge badge-pill badge-dark focus">查看更多..</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="page-panel-title important-text">課程大綱</div>
                                <div class="panel-body">
                                    @if(count($syllabuses) > 0)
                                    <div class="list-group">
                                        @foreach($syllabuses as $syllabus)
                                        <a href="{{url($syllabus->file_path)}}" class="list-group-item" download>
                                            <i class="badge badge-download material-icons">
                                                keyboard_arrow_right
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
                                    <a href="{{ URL::to('academic/syllabus') }}"><span class="badge badge-pill badge-dark focus">查看更多..</span></a>
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
