@extends('layouts.app')

@section('title', 'Grade')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <h2>所有的班級與分數資料</h2>
            <div class="panel panel-default">
              @if(count($classes) > 0)
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($classes as $class)
                        <div class="panel panel-default">
                        <div>教室編號：{{ $class->class_number }}</div>
                        <div>{{ empty($class->group) ? '' : '群組：'.$class->group }}</div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">教室</th>
                                                <th scope="col">學生歷史成績</th>
                                                <th scope="col">本課程所有學生分數</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sections as $section)
                                                @if($class->id == $section->class_id)
                                                <tr>
                                                <td>
                                                    <a href="{{url('grades/section/'.$section->id)}}">{{$section->section_number}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{url('section/students/'.$section->id)}}" class="btn btn-primary btn-xs"><i class="material-icons">visibility</i> 瀏覽</a>
                                                </td>
                                                <td>
                                                    <a href="{{url('grades/section/'.$section->id)}}" role="button" class="btn btn-xs btn-primary"><i class="material-icons">visibility</i> 瀏覽</a>
                                                </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                           
                        </div>
                    @endforeach
                    </div>
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
