@extends('layouts.app')

@section('title', '課程')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card border-primary" style="margin-top: 20px;">
            <div class="card-header">編輯課程資料</div>
            <div class="card-body">
                <div class="panel panel-default">
                    <form class="form-horizontal" action="{{url('edit/course/'.$course->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('course_name') ? ' has-error' : '' }}">
                            <label for="course_name" class="col-md-4 control-label">課程名稱</label>

                            <div class="col-md-6">
                                <input id="course_name" type="text" class="form-control" name="course_name" value="{{ $course->course_name }}" required>

                                @if ($errors->has('course_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('course_time') ? ' has-error' : '' }}">
                            <label for="course_time" class="col-md-4 control-label">上課時段</label>

                            <div class="col-md-6">
                                <input id="course_time" type="text" class="form-control" name="course_time" value="{{ $course->course_time }}" required>

                                @if ($errors->has('course_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('course_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-primary">更新</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
