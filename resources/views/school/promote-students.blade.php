@extends('layouts.app')

@section('title', '學員')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            <h2>所有學員</h2>
            <div class="panel panel-default">
              @if(count($students) > 0)
                @foreach ($students as $student)
                  <div class="page-panel-title">
                    <b>課程</b>：{{ $student->section->section_number}} &nbsp; <b>班級</b>：{{$student->section->class->class_number}}
                    <span class="pull-right"><b>現在時間：</b> &nbsp;{{ Carbon\Carbon::now()->format('Y/d/m h:i A')}}</span>
                  </div>
                   @break($loop->first)
                @endforeach
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @component('components.promote-students',['students'=>$students,'classes'=>$classes,'section_id'=>$section_id])
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
