@extends('layouts.app')

@section('title', '學員')

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
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif
      <div class="card border-primary">
        <div class="card-header">所有學員</div>
        <div class="card-body">
        @if(count($students) > 0)
          @foreach ($students as $student)
            <div class="page-panel-title">
              課程類型：{{ $student->section->section_number}} - {{$student->section->class->class_number}}
            </div>
            @break($loop->first)
          @endforeach
          <div class="panel-body">
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
</div>
@endsection
