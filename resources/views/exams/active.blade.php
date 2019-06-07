@extends('layouts.app')
<<<<<<< HEAD
@section('title', '當前考試')
=======
@section('title', '目前全部考試')
>>>>>>> aef31950fb71df21c686e10884dd57bd54aece5e
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
<<<<<<< HEAD
                <div class="page-panel-title">當前考試</div>
=======
                <div class="page-panel-title">目前全部考試</div>
>>>>>>> aef31950fb71df21c686e10884dd57bd54aece5e

                <div class="panel-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @if(count($exams) > 0)
                        @foreach($exams as $exam)
                            @component('components.active-exams',['exam'=>$exam,'courses'=>$courses])
                            @endcomponent
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
