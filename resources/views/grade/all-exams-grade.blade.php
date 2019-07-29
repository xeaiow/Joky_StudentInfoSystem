@extends('layouts.app')

@section('title', '成績')

@section('content')

<style>
    th {
        font-size: 16px !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container" style="margin-top: 20px;">
    @if(count($classes) > 0)
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach($classes as $class)
        <div class="card" style="margin-top:20px;">
            <div class="card-body">
                <h4 class="card-title">{{ $class->class_number }}</h4>
                <h6 class="card-subtitle mb-2 text-muted">{{ empty($class->group) ? '' : '群組：'.$class->department_name }}</h6>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">子課程</th>
                            <th scope="col">歷史成績</th>
                            <th scope="col">班級列表</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                            @if($class->id == $section->class_id)
                                <tr>
                                    <td>
                                        <a href="{{url('grades/section/'.$section->id)}}">{{ $section->section_number }}</a>
                                    </td>
                                    <td>
                                        <a href="{{url('section/students/'.$section->id)}}" class="btn btn-primary btn-xs"><i class="material-icons">visibility</i></a>
                                    </td>
                                    <td>
                                        <a href="{{url('courses/0/'.$section->id)}}" role="button" class="btn btn-xs btn-primary"><i class="material-icons">visibility</i></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        @else
            沒有資料
        @endif
    </div>
</div>
@endsection
