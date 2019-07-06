@extends('layouts.app')

@section('title', '登入')

@section('content')
<style>
    body {
        background:url(https://hdqwalls.com/download/material-design-4k-2048x1152.jpg) fixed;
            background-size: cover;
    }
    #app {
        color:#edf3ff;
        background:url(https://hdqwalls.com/download/material-design-4k-2048x1152.jpg) fixed;
        background-size: cover;
        font-family: '微軟正黑體', sans-serif;
    }
    :after,:before{box-sizing:border-box}
    .clearfix:after,.clearfix:before{content:'';display:table}
    .clearfix:after{clear:both;display:block}
    a{color:inherit;text-decoration:none}

    .login-wrap{
        width: 100%;
        margin:auto;
        max-width:510px;
        min-height:510px;
        position:relative;
        box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
    }
    .login-html{
        width:100%;
        height:100%;
        position:absolute;
        padding:90px 70px 50px 70px;
        background:rgba(0,0,0,0.5);
    }
    
    .login-html .sign-in, 
    .login-form .group .check{
        display:none;
    }
    .login-html .tab,
    .login-form .group .button{
        text-transform:uppercase;
    }
    .login-html .tab{
        font-size:22px;
        margin-right:15px;
        padding-bottom:5px;
        margin:0 15px 10px 0;
        display:inline-block;
        border-bottom:2px solid transparent;
    }
    .login-html .sign-in:checked + .tab {
        color:#fff;
        border-color:#1161ee;
    }
    .login-form{
        min-height:345px;
        position:relative;
        -webkit-perspective:1000px;
                perspective:1000px;
        -webkit-transform-style:preserve-3d;
                transform-style:preserve-3d;
    }
    .login-form .group{
        margin-bottom:15px;
    }
    .login-form .group .label,
    .login-form .group .input,
    .login-form .group .button{
        width:100%;
        color:#fff;
        display:block;
    }
    .login-form .group .input,
    .login-form .group .button{
        border:none;
        padding:15px 20px;
        border-radius:25px;
        background:rgba(255,255,255,.1);
    }
    .login-form .group input[data-type="password"]{
        text-security:circle;
        -webkit-text-security:circle;
    }
    .login-form .group .label{
        color:#aaa;
        font-size:14px;
    }
    .login-form .group .button{
        background:#1161ee;
    }
    .login-form .group label .icon{
        width:15px;
        height:15px;
        border-radius:2px;
        position:relative;
        display:inline-block;
        background:rgba(255,255,255,.1);
    }
    .login-form .group label .icon:before,
    .login-form .group label .icon:after{
        content:'';
        width:10px;
        height:2px;
        background:#fff;
        position:absolute;
        -webkit-transition:all .2s ease-in-out 0s;
        transition:all .2s ease-in-out 0s;
    }
    .login-form .group label .icon:before{
        left:3px;
        width:5px;
        bottom:6px;
        -webkit-transform:scale(0) rotate(0);
                transform:scale(0) rotate(0);
    }
    .login-form .group label .icon:after{
        top:6px;
        right:0;
        -webkit-transform:scale(0) rotate(0);
                transform:scale(0) rotate(0);
    }
    .login-form .group .check:checked + label{
        color:#fff;
    }
    .login-form .group .check:checked + label .icon{
        background:#1161ee;
    }
    .login-form .group .check:checked + label .icon:before{
        -webkit-transform:scale(1) rotate(45deg);
                transform:scale(1) rotate(45deg);
    }
    .login-form .group .check:checked + label .icon:after{
        -webkit-transform:scale(1) rotate(-45deg);
                transform:scale(1) rotate(-45deg);
    }
    
    .help-block {
        font-weight: 900;
        color: #FFFFFF !important;
    }
    input:focus {
        outline: none !important;
        border:1px solid red;
        box-shadow: 0 0 10px #719ECE;
    }
    label {
        text-align: left !important;
    }
    .back {
        color: #FFFFFF !important;
    }
    .back:hover {
        text-decoration: none !important;
    }
</style>

<div class="login-wrap">
	<div class="login-html">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <!-- <input id="tab-2" type="radio" name="tab" class="for-pwd"><label for="tab-2" class="tab">忘記密碼</label> -->
            <div class="login-form">
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="email" class="label">帳號</label>
                        <input id="email" name="email" type="text" class="input" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                {{ $errors->first('phone_number') }}
                            </span>
                        @endif
                    </div>
                    <div class="group">
                        <label for="password" class="label">密碼</label>
                        <input id="password" name="password" type="password" class="input" data-type="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="登入系統">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-right"><a class="back" href="{{ route('password.request') }}">忘記密碼</a></p>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
