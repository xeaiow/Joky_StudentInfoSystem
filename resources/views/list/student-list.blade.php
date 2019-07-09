@extends('layouts.app')

@section('title', '所有學生')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
              @if(count($users) > 0)
              @foreach ($users as $user)
                @if (Session::has('section-attendance'))
                <ol class="breadcrumb" style="margin-top: 3%;">
                    <li><a href="{{url('school/sections?att=1')}}" style="color:#3b80ef;">課程出席狀況</a></li>
                    <li class="active">
                    @switch($user->role)
                        @case('student')
                            所有學生
                            @break
                    @endswitch</li>
                </ol>
                @endif
                <div class="page-panel-title">
                @switch($user->role)
                    @case('student')
                        所有學生
                        @break
                @endswitch
                </div>
                 @break($loop->first)
              @endforeach
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @component('components.users-list',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                    @endcomponent
                </div>
              @else
                <div class="panel-body">
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>目前沒有學生資料</strong>，<a href="{{ url('register/student') }}" class="alert-link">立即新增</a>
                    </div>
                </div>
              @endif
            </div>
        </div>
    </div>
</div>
@endsection
