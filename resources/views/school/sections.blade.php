@extends('layouts.app')

@section('title', '課程出席狀況')

@section('content')
<style>
    #cls-sec .panel{
        margin-bottom: 0%;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default" id="cls-sec">
              @if(count($classes) > 0)
                @foreach ($classes as $class)
                    <div class="panel panel-default">
                    <div>課程編號：{{ (int) $class->class_number+1 }}</div>
                    <div>{{ empty($class->group) ? '' : '課程分類：'.$class->group }}</div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>名稱</th>
                                            @if(isset($_GET['att']) && $_GET['att'] == 1)
                                            <th>今天出席狀況</th>
                                            <th>每位學生出席狀況</th>
                                            <th>出席</th>
                                            @endif
                                            @if(isset($_GET['course']) && $_GET['course'] == 1)
                                            <th>課程大綱</th>
                                            <th>課程出席狀況</th>
                                            <th>待辦事項</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                            @if($class->id == $section->class_id)
                                            <tr>
                                            <td>
                                                <a href="{{url('courses/0/'.$section->id)}}">{{$section->section_number}}</a>
                                            </td>
                                            @if(isset($_GET['att']) && $_GET['att'] == 1)
                                                @foreach ($exams as $ex)
                                                    @if ($ex->class_id == $class->id)
                                                        <td>
                                                            <a role="button" class="btn btn-primary btn-xs" href="{{url('attendances/'.$section->id.'/0/'.$ex->exam_id)}}"><i class="material-icons">visibility</i> 查看</a>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            <td>
                                                <a role="button" class="btn btn-primary btn-xs" href="{{url('attendances/'.$section->id)}}"><i class="material-icons">visibility</i> 查看</a>
                                            </td>
                                            <td>
                                                <?php
                                                    $ce = 0;    
                                                ?>
                                                @foreach ($exams as $ex)
                                                    @if ($ex->class_id == $class->id)
                                                        <?php
                                                            $ce = 1;
                                                        ?>
                                                        <a role="button" class="btn btn-primary btn-xs" href="{{url('attendances/'.$section->id.'/0/'.$ex->exam_id)}}"><i class="material-icons">spellcheck</i> 送出點名表</a>
                                                    @endif
                                                @endforeach
                                                @if($ce == 0)
                                                    Assign Class Under Exam
                                                @endif
                                            </td>
                                            @endif
                                            @if(isset($_GET['course']) && $_GET['course'] == 1)
                                            <td>
                                                <a role="button" class="btn btn-primary btn-xs" href="{{url('courses/0/'.$section->id)}}"><i class="material-icons">visibility</i> 查看</a>
                                            </td>
                                            <td>
                                                <a role="button" class="btn btn-primary btn-xs" href="{{url('section/students/'.$section->id.'?section=1')}}"><i class="material-icons">visibility</i> 查看</a>
                                            </td>
                                            <td>
                                                <a role="button" class="btn btn-primary btn-xs" href="{{url('academic/routine/'.$section->id)}}"><i class="material-icons">visibility</i> 查看</a>
                                            </td>
                                            @endif
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                       
                    </div>
                @endforeach
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
