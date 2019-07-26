@extends('layouts.app')

@section('title', '新增公告')

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
                <div class="card-header">新增公告</div>
                <div class="card-body">
                @component('components.file-uploader',['upload_type'=>'event'])
                @endcomponent
                </div>
            </div><br />
            @component('components.uploaded-files-list',['files'=>$files,'upload_type'=>'event'])
            @endcomponent
        </div>
    </div>
</div>
@endsection
