@extends('layouts.app')

@section('title', '管理成員')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{url('create-school')}}"><i class="material-icons">arrow_left</i> 回客戶列表</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10" id="main-container">
            <div class="panel panel-default">
                @if(count($admins) > 0)
                <div class="panel-body">
                    <table class="table table-striped">
                        <tr>
                            <th>姓名</th>
                            <th>編號</th>
                            <th>電子信箱</th>
                            <th>手機</th>
                            <th>地址</th>
                            <!-- <th>備註</th> -->
                            <th>操作</th>
                        </tr>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>
                                {{$admin->name}}
                            </td>
                            <td>{{$admin->student_code}}</td>
                            <td>{{$admin->email}}</td>
                            <td>{{$admin->phone_number}}</td>
                            <td>{{$admin->address}}</td>
                            <!-- <td>{{$admin->about}}</td> -->
                            <td>
                            <div class="btn-group" role="group">
                            <a href="{{url('edit/user/'.$admin->id)}}" class="btn btn-xs btn-primary" role="button"><i class="material-icons">edit</i></a>
                                @if($admin->active == 0)
                                <a href="{{url('master/activate-admin/'.$admin->id)}}" class="btn btn-xs btn-danger" role="button"><i class="material-icons">check</i></a>
                                @else
                                <a href="{{url('master/deactivate-admin/'.$admin->id)}}" class="btn btn-xs btn-default" role="button"><i class="material-icons">clear</i></a>
                                @endif
                            </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @else
                <div class="card border-primary mb-3" style="margin-top:20px;">
                    <div class="card-header text-center">成員</div>
                    <div class="card-body">
                        <a class="btn btn-primary btn-sm" href="{{url('register/admin/'.$school->id.'/'.$school->code)}}">新增</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection