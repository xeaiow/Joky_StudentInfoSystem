@extends('layouts.app')

@section('title', '考試卷管理')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">考試卷管理</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.exams-list',['exams'=>$exams])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
