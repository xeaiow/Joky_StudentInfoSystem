@extends('layouts.app')
<<<<<<< HEAD
@section('title', '新增考試卷')
=======
@section('title', '新增考試')
>>>>>>> aef31950fb71df21c686e10884dd57bd54aece5e
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <div class="panel panel-default">
<<<<<<< HEAD
                <div class="page-panel-title">新增考試卷</div>
=======
                <div class="page-panel-title">新增考試</div>
>>>>>>> aef31950fb71df21c686e10884dd57bd54aece5e

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @component('components.add-exam-form',['classes'=>$classes])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
