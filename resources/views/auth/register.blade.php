@extends('layouts.app')

@section('title', '新增人員')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<div class="container{{ (\Auth::user()->role == 'master')? '' : '-fluid' }}">
    <div class="row">
        @if(\Auth::user()->role != 'master')
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        @endif
        <div class="col-md-10" id="main-container">
            @if (session('status'))
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('status') }}
                @if (session('register_school_id'))
                    <a href="{{ url('school/admin-list/' . session('register_school_id')) }}" target="_blank" class="text-white pull-right">查看管理員</a>
                @endif
            </div>
            @endif

            <div class="card border-primary" style="margin-top: 20px;">
                <div class="card-header text-center">
                    @switch(session('register_role'))
                        @case('admin')
                            新增管理員
                            @break
                        @case('student')
                            新增學員
                            @break
                        @case('teacher')
                            新增教師
                            @break
                        @case('accountant')
                            新增會計師
                            @break
                        @case('librarian')
                            新增圖書館員
                            @break
                        @default
                    @endswitch
                </div>
                <div class="card-body">  
                    <form class="form-horizontal" method="POST" id="registerForm" action="{{ url('register/'.session('register_role')) }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-3 control-label">姓名</label>
                            <div class="col-md-7">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-3 control-label">電子信箱</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col-md-3 control-label">手機號碼</label>

                            <div class="col-md-7">
                                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">

                                @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label">密碼</label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-3 control-label">確認密碼</label>

                            <div class="col-md-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                    required>
                            </div>
                        </div>
                        @if(session('register_role', 'student') == 'student')
                        <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                            <label for="section" class="col-md-3 control-label">選擇課程</label>

                            <div class="col-md-7">
                                <select id="section" class="form-control" name="section" required>
                                    @foreach (session('register_sections') as $section)
                                    <option value="{{$section->id}}">課程：{{$section->section_number}}, 班級：
                                        {{$section->class->class_number}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('section'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday" class="col-md-3 control-label">出生年月日</label>

                            <div class="col-md-7">
                                <input id="birthday" type="text" class="form-control" name="birthday" value="{{ old('birthday') }}"
                                    required>

                                @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if(session('register_role', 'teacher') == 'teacher')
                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            <label for="department" class="col-md-3 control-label">教師類別</label>

                            <div class="col-md-7">
                                <select id="department" class="form-control" name="department_id" required>
                                    @if (count(session('departments')) > 0)
                                        @foreach (session('departments') as $d)
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
                            <label for="class_teacher" class="col-md-3 control-label">班級導師</label>
                            <div class="col-md-7">
                                <select id="class_teacher" class="form-control" name="class_teacher_section_id">
                                    <option selected="selected" value="0">無</option>
                                    @foreach (session('register_sections') as $section)
                                    <option value="{{$section->id}}">課程： {{$section->section_number}} 班級：
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
                        <!-- <div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                            <label for="blood_group" class="col-md-3 control-label">血型</label>

                            <div class="col-md-7">
                                <select id="blood_group" class="form-control" name="blood_group">
                                    <option selected="selected">A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                    <option>O+</option>
                                    <option>O-</option>
                                </select>

                                @if ($errors->has('blood_group'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('blood_group') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                            <label for="nationality" class="col-md-3 control-label">國籍</label>

                            <div class="col-md-7">
                                <input id="nationality" type="text" class="form-control" name="nationality" value="{{ old('nationality') }}"
                                    required>

                                @if ($errors->has('nationality'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-md-3 control-label">性別</label>

                            <div class="col-md-7">
                                <select id="gender" class="form-control" name="gender">
                                    <option selected="selected">男</option>
                                    <option>女</option>
                                </select>

                                @if ($errors->has('gender'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if(session('register_role', 'student') == 'student')
                        <!-- <div class="form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                            <label for="version" class="col-md-3 control-label">國籍</label>

                            <div class="col-md-7">
                                <select id="version" class="form-control" name="version">
                                    <option selected="selected">Bangla</option>
                                    <option>English</option>
                                </select>

                                @if ($errors->has('version'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('version') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="col-md-3 control-label">學籍</label>

                            <div class="col-md-7">
                                <input id="session" type="text" class="form-control" name="session" value="{{ old('session') }}"
                                    required>

                                @if ($errors->has('session'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                            <label for="group" class="col-md-3 control-label">補習課程 (選填)</label>

                            <div class="col-md-7">
                                <input id="group" type="text" class="form-control" name="group" value="{{ old('group') }}"
                                    placeholder="Science, Arts, Commerce,etc.">

                                @if ($errors->has('group'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('group') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                            <label for="religion" class="col-md-3 control-label">信仰</label>

                            <div class="col-md-7">
                                <select id="religion" class="form-control" name="religion">
                                    <option selected="selected">Islam</option>
                                    <option>Hinduism</option>
                                    <option>Christianism</option>
                                    <option>Buddhism</option>
                                    <option>Other</option>
                                </select>

                                @if ($errors->has('religion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('religion') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-3 control-label">地址</label>

                            <div class="col-md-7">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}"
                                    required>

                                @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                            <label for="about" class="col-md-3 control-label">備註</label>

                            <div class="col-md-7">
                                <textarea id="about" class="form-control" name="about">{{ old('about') }}</textarea>

                                @if ($errors->has('about'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                            <label for="father_name" class="col-md-3 control-label">父親姓名</label>

                            <div class="col-md-7">
                                <input id="father_name" type="text" class="form-control" name="father_name" value="{{ old('father_name') }}"
                                    required>

                                @if ($errors->has('father_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                            <label for="father_phone_number" class="col-md-3 control-label">父親聯絡電話</label>

                            <div class="col-md-7">
                                <input id="father_phone_number" type="text" class="form-control" name="father_phone_number"
                                    value="{{ old('father_phone_number') }}">

                                @if ($errors->has('father_phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                            <label for="father_national_id" class="col-md-3 control-label">父親身分證字號</label>

                            <div class="col-md-7">
                                <input id="father_national_id" type="text" class="form-control" name="father_national_id"
                                    value="{{ old('father_national_id') }}">

                                @if ($errors->has('father_national_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_national_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">
                            <label for="father_occupation" class="col-md-3 control-label">父親職業</label>

                            <div class="col-md-7">
                                <input id="father_occupation" type="text" class="form-control" name="father_occupation"
                                    value="{{ old('father_occupation') }}">

                                @if ($errors->has('father_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">
                            <label for="father_designation" class="col-md-3 control-label">父親綽號</label>

                            <div class="col-md-7">
                                <input id="father_designation" type="text" class="form-control" name="father_designation"
                                    value="{{ old('father_designation') }}">

                                @if ($errors->has('father_designation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_designation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">
                            <label for="father_annual_income" class="col-md-3 control-label">父親年收入</label>

                            <div class="col-md-7">
                                <input id="father_annual_income" type="text" class="form-control" name="father_annual_income"
                                    value="{{ old('father_annual_income') }}">

                                @if ($errors->has('father_annual_income'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('father_annual_income') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
                            <label for="mother_name" class="col-md-3 control-label">母親姓名</label>

                            <div class="col-md-7">
                                <input id="mother_name" type="text" class="form-control" name="mother_name" value="{{ old('mother_name') }}"
                                    required>

                                @if ($errors->has('mother_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">
                            <label for="mother_phone_number" class="col-md-3 control-label">母親聯絡方式</label>

                            <div class="col-md-7">
                                <input id="mother_phone_number" type="text" class="form-control" name="mother_phone_number"
                                    value="{{ old('mother_phone_number') }}">

                                @if ($errors->has('mother_phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">
                            <label for="mother_national_id" class="col-md-3 control-label">母親身分證字號</label>

                            <div class="col-md-7">
                                <input id="mother_national_id" type="text" class="form-control" name="mother_national_id"
                                    value="{{ old('mother_national_id') }}">

                                @if ($errors->has('mother_national_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_national_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">
                            <label for="mother_occupation" class="col-md-3 control-label">母親職業</label>

                            <div class="col-md-7">
                                <input id="mother_occupation" type="text" class="form-control" name="mother_occupation"
                                    value="{{ old('mother_occupation') }}">

                                @if ($errors->has('mother_occupation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_occupation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">
                            <label for="mother_designation" class="col-md-3 control-label">母親綽號</label>

                            <div class="col-md-7">
                                <input id="mother_designation" type="text" class="form-control" name="mother_designation"
                                    value="{{ old('mother_designation') }}">

                                @if ($errors->has('mother_designation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_designation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->

                        <!-- <div class="form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">
                            <label for="mother_annual_income" class="col-md-3 control-label">母親年收入</label>

                            <div class="col-md-7">
                                <input id="mother_annual_income" type="text" class="form-control" name="mother_annual_income"
                                    value="{{ old('mother_annual_income') }}">

                                @if ($errors->has('mother_annual_income'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->
                        @endif

                        <div class="form-group">
                            <label class="col-md-3 control-label">頭像</label>
                            <div class="col-md-7">
                                <input type="hidden" id="picPath" name="pic_path">
                                @component('components.file-uploader',['upload_type'=>'profile'])
                                @endcomponent
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-8">
                                <button type="submit" id="registerBtn" class="btn btn-primary">
                                    新增
                                </button>
                                <a class="btn btn-default" href="{{ url('create-school') }}">返回設定</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('#birthday').datepicker({
            format: "yyyy-mm-dd",
        });
        $('#session').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    });
    $('#registerBtn').click(function () {
        $("#registerForm").submit();
    });
</script>
@endsection