@extends('layouts.app')

@section('title', '課程')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <h2>我的授課班級</h2>
            <div class="panel panel-default">
              @if(count($courses) > 0)
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
