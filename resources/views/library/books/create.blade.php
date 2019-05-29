@extends('layouts.app')

@section('title', '新增書籍')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" id="side-navbar">
                @include('layouts.leftside-menubar')
            </div>
            <div class="col-md-8" id="main-container">
                <div class="panel panel-default">
                    <div class="page-panel-title">新增書籍</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('library.books.store') }}" method="POST" class="form-horizontal">
                            {{ csrf_field() }}
                            @include('library.books.form')

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-danger">儲存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
