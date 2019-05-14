@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="page-panel-title">開發者控制台</div>

                <div class="panel-body">
                    <a class="btn btn-danger btn-lg btn-block" href="{{url('create-school')}}" role="button">客戶管理</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
