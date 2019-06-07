@extends('layouts.app')

@section('title', '所有書籍')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2" id="side-navbar">
                @include('layouts.leftside-menubar')
            </div>
            <div class="col-md-10" id="main-container">
                <div class="panel panel-default">
                    <div class="page-panel-title">書籍詳情</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>書籍編號</th>
                                    <td>{{ $book->book_code }}</td>
                                    <th>書名</th>
                                    <td>{{ $book->title }}</td>
                                    <th>作者</th>
                                    <td>{{ $book->author }}</td>
                                    <th>關於</th>
                                    <td>{{ $book->about }}</td>
                                </tr>
                                <tr>
                                    <th>數量</th>
                                    <td>{{ $book->quantity }}</td>
                                    <th>幾號架上</th>
                                    <td>{{ $book->rackNo }}</td>
                                    <th>第幾排</th>
                                    <td>{{ $book->rowNo }}</td>
                                    <th>類型</th>
                                    <td>{{ $book->type }}</td>
                                </tr>
                                <tr>
                                    <th>封面</th>
                                    <td>
                                        <img src="{{ $book->img_path }}" alt="{{ $book->title }}" />
                                    </td>
                                    <th>價錢</th>
                                    <td>{{ $book->price }}</td>
                                    <th>分級</th>
                                    <td>{{ $book->class->class_number }}</td>
                                    <th>學校</th>
                                    <td>{{ $book->school->name }}</td>
                                </tr>
                                <tr>
                                    <th>購買日期</th>
                                    <td>{{ $book->created_at }}</td>
                                    <th>更新時間</th>
                                    <td>{{ $book->updated_at }}</td>
                                    <th>書籍註冊人</th>
                                    <td>{{ $book->user->name }}</td>
                                </tr>
                            </thead>
                        </table>

                    </div>
                    <div class="row">
                        <a href="{{ route('library.books.index') }}" class="btn btn-xs btn-primary">返回</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
