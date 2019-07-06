@extends('layouts.app')

@section('title', '編輯資料')

@section('content')
<div class="container{{ (\Auth::user()->role == 'master')? '' : '-fluid' }}">
    <div class="row">
        @if(\Auth::user()->role != 'master')
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        @endif
        <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 8 }}" id="main-container">
            
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="panel panel-default">
                <div class="page-panel-title text-center">編輯{{ $user->name }}</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('edit/user') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="user_role" value="{{$user->role}}">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">機構名稱</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"
                                    required>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">電子信箱</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ $user->email }}">

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-4 control-label">手機號碼</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control" name="phone_number"
                                    value="{{ $user->phone_number }}">

                                @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        @if($user->role == 'teacher')
                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            <label for="department" class="col-md-4 control-label">部門</label>

                            <div class="col-md-6">
                                <select id="department" class="form-control" name="department_id">
                                    @if (count($departments)) > 0)
                                    @foreach ($departments as $d)
                                    <option value="{{$d->id}}">{{$d->department_name}}</option>
                                    @endforeach
                                    @endif
                                </select>

                                @if ($errors->has('department'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('department') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('class_teacher') ? ' has-error' : '' }}">
                            <label for="class_teacher" class="col-md-4 control-label">Class Teacher</label>

                            <div class="col-md-6">
                                <select id="class_teacher" class="form-control" name="class_teacher_section_id">
                                    <option selected="selected" value="{{$user->section->id}}">Section:
                                        {{$user->section->section_number}} Class:
                                        {{$user->section->class->class_number}}</option>
                                    @foreach ($sections as $section)
                                    <option value="{{$section->id}}">Section: {{$section->section_number}} Class:
                                        {{$section->class->class_number}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('class_teacher'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('class_teacher') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">地址</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address"
                                    value="{{ $user->address }}">

                                @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                            <label for="about" class="col-md-4 control-label">描述</label>

                            <div class="col-md-6">
                                <textarea id="about" class="form-control" name="about">{{ $user->about }}</textarea>

                                @if ($errors->has('about'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($user->role == 'student')

                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-4 control-label">生日</label>

                            <div class="col-md-6">
                                <input id="birthday" type="text" class="form-control" name="birthday" required>

                                @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="col-md-4 control-label">Session</label>

                            <div class="col-md-6">
                                <input id="session" type="text" class="form-control" name="session" required>

                                @if ($errors->has('session'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                            <label for="group" class="col-md-4 control-label">群組</label>

                            <div class="col-md-6">
                                <input id="group" type="text" class="form-control" name="group"
                                    value="{{ $user->studentInfo['group'] }}"
                                    placeholder="Science, Arts, Commerce,etc.">

                                @if ($errors->has('group'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('group') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                            <label for="father_name" class="col-md-4 control-label">家長姓名</label>

                            <div class="col-md-6">
                                <input id="father_name" type="text" class="form-control" name="father_name"
                                    value="{{ $user->studentInfo['father_name'] }}" required>

                                @if ($errors->has('father_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                            <label for="father_phone_number" class="col-md-4 control-label">家長手機號碼
                                Number</label>

                            <div class="col-md-6">
                                <input id="father_phone_number" type="text" class="form-control"
                                    name="father_phone_number" value="{{ $user->studentInfo['father_phone_number'] }}">

                                @if ($errors->has('father_phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                            <label for="father_national_id" class="col-md-4 control-label">Father's National ID</label>

                            <div class="col-md-6">
                                <input id="father_national_id" type="text" class="form-control"
                                    name="father_national_id" value="{{ $user->studentInfo['father_national_id'] }}">

                                @if ($errors->has('father_national_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_national_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">
                            <label for="father_occupation" class="col-md-4 control-label">Father's Occupation</label>

                            <div class="col-md-6">
                                <input id="father_occupation" type="text" class="form-control" name="father_occupation"
                                    value="{{ $user->studentInfo['father_occupation'] }}">

                                @if ($errors->has('father_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">
                            <label for="father_designation" class="col-md-4 control-label">Father's Designation</label>

                            <div class="col-md-6">
                                <input id="father_designation" type="text" class="form-control"
                                    name="father_designation" value="{{ $user->studentInfo['father_designation'] }}">

                                @if ($errors->has('father_designation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_designation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">
                            <label for="father_annual_income" class="col-md-4 control-label">Father's Annual
                                Income</label>

                            <div class="col-md-6">
                                <input id="father_annual_income" type="text" class="form-control"
                                    name="father_annual_income"
                                    value="{{ $user->studentInfo['father_annual_income'] }}">

                                @if ($errors->has('father_annual_income'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_annual_income') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
                            <label for="mother_name" class="col-md-4 control-label">Mother's Name</label>

                            <div class="col-md-6">
                                <input id="mother_name" type="text" class="form-control" name="mother_name"
                                    value="{{ $user->studentInfo['mother_name'] }}" required>

                                @if ($errors->has('mother_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">
                            <label for="mother_phone_number" class="col-md-4 control-label">Mother's Phone
                                Number</label>

                            <div class="col-md-6">
                                <input id="mother_phone_number" type="text" class="form-control"
                                    name="mother_phone_number" value="{{ $user->studentInfo['mother_phone_number'] }}">

                                @if ($errors->has('mother_phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">
                            <label for="mother_national_id" class="col-md-4 control-label">Mother's National ID</label>

                            <div class="col-md-6">
                                <input id="mother_national_id" type="text" class="form-control"
                                    name="mother_national_id" value="{{ $user->studentInfo['mother_national_id'] }}">

                                @if ($errors->has('mother_national_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_national_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">
                            <label for="mother_occupation" class="col-md-4 control-label">Mother's Occupation</label>

                            <div class="col-md-6">
                                <input id="mother_occupation" type="text" class="form-control" name="mother_occupation"
                                    value="{{ $user->studentInfo['mother_occupation'] }}">

                                @if ($errors->has('mother_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">
                            <label for="mother_designation" class="col-md-4 control-label">Mother's Designation</label>

                            <div class="col-md-6">
                                <input id="mother_designation" type="text" class="form-control"
                                    name="mother_designation" value="{{ $user->studentInfo['mother_designation'] }}">

                                @if ($errors->has('mother_designation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_designation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">
                            <label for="mother_annual_income" class="col-md-4 control-label">Mother's Annual
                                Income</label>

                            <div class="col-md-6">
                                <input id="mother_annual_income" type="text" class="form-control"
                                    name="mother_annual_income"
                                    value="{{ $user->studentInfo['mother_annual_income'] }}">

                                @if ($errors->has('mother_annual_income'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 text-right">
                                <a href="javascript:location.href='{{ URL::to('school/admin-list/'.$user->school_id) }}'" class="btn btn-default" style="margin-right: 2%;"
                                    role="button">回去列表</a>
                                <input type="submit" role="button" class="btn btn-success" value="更改">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
    rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('#birthday').datepicker({
            format: "yyyy-mm-dd",
        });
        $('#birthday').datepicker('setDate',
            "{{ Carbon\Carbon::parse($user->studentInfo['birthday'])->format('Y-d-m') }}");
        $('#session').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
        $('#session').datepicker('setDate',
            "{{ Carbon\Carbon::parse($user->studentInfo['session'])->format('Y') }}");
    });
</script>
@endsection