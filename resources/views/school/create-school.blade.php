@extends('layouts.app')

@section('title', '設定')

@section('content')
<style>
.dropdown-menu li a:hover {
  color: #000 !important;
}  
</style>

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
            @if (session('errorMsg'))
              <div class="alert alert-danger">
                {{ session('errorMsg') }}
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
                    <div class="col-md-11"></div>
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
                    <div class="row">
                      <div class="col-md-4">
                        <div class="card border-light mb-3">
                          <div class="card-header nav-link-align-btn">
                            教育類型
                            <span class="pull-right">
                              <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#departmentModal">新增</button>
                            </span>
                          </div>
                          <div class="card-body">
                            @foreach ($departments as $d)
                              @if( $d->school_id == $school->id )
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-info btn-xs">{{ $d->department_name }}</button>
                                      <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li>
                                          <a data-toggle="modal" class="openEditDepartmentModal" str="{{ $d->department_name }}" deptId="{{ $d->id }}">編輯</a>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>
                                </div><br />
                              @endif
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card border-light mb-3">
                          <div class="card-header nav-link-align-btn">
                            課程與班級
                            <span class="pull-right">
                              <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addClassModal{{$school->id}}">新增</button>
                            </span>
                          </div>
                          <div class="card-body"> 
                            @if(\Auth::user()->school_id == $school->id)
                              @include('layouts.master.add-class-form')
                              <div class="row">
                                @foreach($classes as $class)
                                  @if($class->school_id == $school->id)
                                  <div class="col-sm-12">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{$class->id}}" style="margin-top: 5%;">
                                      {{ $class->class_number }} - {{ $class->department_name }}
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{$class->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">{{ $class->class_number }}</h4>
                                          </div>
                                          <div class="modal-body">
                                            <ul class="list-group">
                                              
                                                @foreach($sections as $section)
                                                  @if($section->class_id == $class->id)
                                                    <li class="list-group-item">{{ $section->section_number }} &nbsp;
                                                      <a class="btn btn-xs btn-primary" href="{{ url('courses/0/'.$section->id) }}">檢視班級</a>
                                                      <span class="pull-right"> &nbsp;&nbsp;
                                                        <a class="btn btn-xs btn-default" data-toggle="collapse" href="#collapseForNewCourse{{ $section->id }}" aria-expanded="false" aria-controls="collapseForNewCourse{{ $section->id }}">新增班級</a>  
                                                        <a class="btn btn-xs btn-default" href="{{ url('school/promote-students/'.$section->id) }}">管理學生</a>
                                                      </span>
                                                      @include('layouts.master.add-course-form')
                                                    </li>
                                                  @endif
                                                @endforeach
                                              
                                            </ul>
                                            @include('layouts.master.create-section-form')
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  @endif
                                @endforeach
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card border-light mb-3">
                          <div class="card-header nav-link-align-btn">
                            管理角色
                          </div>
                            <div class="card-body">
                            @foreach($schools as $school)
                              @if(\Auth::user()->role == 'admin' && \Auth::user()->school_id == $school->id)
                                <a class="btn btn-primary btn-sm" href="{{url('register/student')}}" >學員</a>
                                <a class="btn btn-primary btn-sm" href="{{url('register/teacher')}}">教師</a>
                              @endif
                            @endforeach
                            </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">新增教育類型</h4>
                          </div>
                          <div class="modal-body">
                            <form action="{{ url('school/add-department') }}" method="post">
                              {{ csrf_field() }}
                              <div class="form-group">
                                <label>類型名稱</label>
                                <input type="text" class="form-control" name="department_name" placeholder="英語、數學、自然..">
                              </div>
                              <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary btn-sm">確定</button>
                              </div>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>


                    <!-- 編輯教育類型 Modal -->
                    <div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 id="edit-department-title">編輯</h4>
                          </div>
                          <div class="modal-body">
                            <form action="" id="edit-department-form" method="post">
                              {{ csrf_field() }}
                              <div class="form-group">
                                <label>教育類型名稱</label>
                                <input type="text" class="form-control" name="department_name" id="department_name">
                              </div>
                              <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">更改</button>
                              </div>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    
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
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
        </div>
    </div>
</div>
<script>
$(".openEditDepartmentModal").click(function() {
  var resourceName = $(this).attr('str');
  $("#editDepartmentModal").modal('show');
  $("#department_name").val(resourceName); 
  $("#edit-department-title").text('編輯' + resourceName);
  $("#edit-department-form").attr('action', '//' + window.location.host + '/' + 'school/edit-department/' + $(this).attr('deptId'));
});
  
</script>
@endsection
