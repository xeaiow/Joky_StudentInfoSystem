@extends('layouts.app')

@section('title', 'Impersonate')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <table class="table">
            <thead>
                <tr class="table-list">
                    <th>姓名</th>
                    <th>角色</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($other_users as $other_user)
                <form method="POST" action="{{ url('/user/config/impersonate') }}">
                    {{ csrf_field() }}
                    <tr>
                        <td>{{ $other_user->name }}</td>
                        <td>
                            @switch($other_user->role)
                                @case('admin')
                                    管理員
                                    @break
                                @case('accountant')
                                    會計師
                                    @break
                                @case('librarian')
                                    圖書館員
                                    @break
                                @case('teacher')
                                    教師
                                    @break
                                @case('student')
                                    學生
                                    @break
                                @case('master')
                                    開發者
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <input type="hidden" name="id" value="{{$other_user->id}}" />
                            <button class="btn-xs btn-primary">模擬</button>
                        </td>
                    </tr>
                </form>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
