@extends('layouts.app')

@section('title', '管理客戶')

@section('content')
<div class="container-fluid">
    <div class="row">
      @if(\Auth::user()->role != 'master')
        <div class="col-md-2" id="side-navbar">
          @include('layouts.leftside-menubar')
        </div>
      @endif
        <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 10 }}" id="main-container">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-default">
              <div class="panel-body table-responsive">
                @if(\Auth::user()->role == 'master')
                  @include('layouts.master.create-school-form')
                  <div class="row">
                    <div class="col-md-11">
                      <h2 class="text-center">客戶列表</h2>
                    </div>
                    <div class="col-md-1 text-right" style="line-height:80px;">
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#schoolModal">新增客戶</button>
                    </div>
                  </div>
                @endif
                <table class="table table-hover customer-list">
                  <thead>
                    <tr class="table-primary">
                      @if(\Auth::user()->role == 'master')
                        <th scope="col">機構名稱</th>
                        <th scope="col">聯絡電話</th>
                        <th scope="col">描述</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($schools as $school)
                  @if(\Auth::user()->school_id == $school->id)
                    <h4>課程</h4>
                    <a href="#collapse{{($loop->index + 1)}}" role="button" class="btn btn-primary btn-sm" data-toggle="collapse" aria-expanded="false" aria-controls="collapse{{($loop->index + 1)}}">顯示所有課程</a>
                    <br />
                    <br />
                  @endif
                    @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
                    <tr>
                      @if(\Auth::user()->role == 'master')
                      <td><small>{{$school->name}}</small></td>
                      <td><small>{{$school->code}}</small></td>
                      <td><small>{{$school->about}}</small></td>
                      @endif
                      @if(\Auth::user()->role == 'master')
                        <td>
                          <a class="btn btn-primary btn-xs" role="button" href="{{url('register/admin/'.$school->id.'/'.$school->code)}}"><small>新增</small></a>
                        </td>
                        <td>
                          <a class="btn btn-primary btn-xs" role="button" href="{{url('school/admin-list/'.$school->id)}}"><small>查看</small></a>
                        </td>
                      @endif
                    </tr>
                    @if(\Auth::user()->school_id == $school->id)
                    <tr class="collapse" id="collapse{{($loop->index + 1)}}" aria-labelledby="heading{{($loop->index + 1)}}" aria-expanded="false">
                      <td colspan="12">
                        @include('layouts.master.add-class-form')
                            <div class="row">
                              @foreach($classes as $class)
                                @if($class->school_id == $school->id)
                                <div class="col-sm-3">
                                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal{{$class->id}}" style="margin-top: 5%;">{{$class->class_number}} {{!empty($class->group)? '- '.$class->group:''}}</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="myModal{{$class->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                          <h4 class="modal-title" id="myModalLabel">{{$class->class_number}}</h4>
                                        </div>
                                        <div class="modal-body">
                                          <ul class="list-group">
                                            @foreach($sections as $section)
                                              @if($section->class_id == $class->id)
                                              <li class="list-group-item">課程 {{$section->section_number}} &nbsp;
                                                <a class="btn btn-xs btn-default" href="{{url('courses/'.$class->id.'/'.$section->id)}}">相關課程</a>
                                                <span class="pull-right"> &nbsp;&nbsp;
                                                  <a  class="btn btn-xs btn-primary" href="{{url('school/promote-students/'.$section->id)}}">管理學生</a>
                                                </span>
                                                @include('layouts.master.add-course-form')
                                              </li>
                                              @endif
                                            @endforeach
                                          </ul>
                                          @include('layouts.master.create-section-form')
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">關閉</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
                              @endforeach
                            </div>
                      </td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                  </tbody>
                </table>
                @foreach($schools as $school)
                  @if(\Auth::user()->role == 'admin' && \Auth::user()->school_id == $school->id)
                    <h4>新增角色</h4>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <a class="btn btn-primary btn-sm" href="{{url('register/student')}}">學員</a>
                      <a class="btn btn-primary btn-sm" href="{{url('register/teacher')}}">教師</a>
                      <a class="btn btn-primary btn-sm" href="{{url('register/accountant')}}">會計師</a>
                      <a class="btn btn-primary btn-sm" href="{{url('register/librarian')}}">圖書館員</a>
                    </div>
                    @break
                  @endif
                @endforeach
              </div>
          </div>
        </div>
    </div>
</div>
@endsection
