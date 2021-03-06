@extends('layouts.app')

@section('title', '學生資訊')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<style>
.ck-editor__editable{
    min-height: 200px;
}
.alert-success a, .alert-success a:hover {
    color: #FFF !important;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-10" id="main-container">
            @if(count($students) > 0)
            @foreach ($students as $student)
            <h3>課程學生人數： {{$student->student->section->class->class_number}}
            <br />班級:
                {{$student->student->section->section_number}}</h3>
            @break
            @endforeach
            <h4>推送訊息給學生</h4>
            @endif
            <div class="panel panel-default">
                @if(count($students) > 0)
                <div class="panel-body">
                    <div class="col-md-6">
                        <table class="table table-bordered table-condensed table-striped">
                            <tr>
                                <th>
                                    <div class="checkbox">
                                        <label style="font-weight:bold;">
                                            <input type="checkbox" id="selectAll"> 選取全部
                                        </label>
                                    </div>
                                </th>
                                <th>學號</th>
                                <th>姓名</th>
                            </tr>
                            @foreach ($students as $student)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="recipients[]" form="msgForm"
                                                value="{{$student->student->id}}">
                                        </label>
                                    </div>
                                </td>
                                <td>{{$student->student->student_code}}</td>
                                <td><a
                                        href="{{url('user/'.$student->student->student_code)}}">{{$student->student->name}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-6">
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
                        <form action="{{url('message/students')}}" method="POST" id="msgForm">
                            {{ csrf_field() }}
                            <input type="hidden" name="teacher_id" value="{{$teacher_id}}">
                            <input type="hidden" name="section_id" value="{{$section_id}}">
                            <div class="form-group">
                                <label for="msg">內容： </label>
                                <textarea name="msg" class="form-control" id="msg" cols="30" rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="material-icons">send</i> 送出</button>
                        </form>
                    </div>
                </div>
                <script>
                    $(function () {
                        var r = $(':checkbox[name="recipients[]"]');
                        $('#selectAll').on('change', function () {
                            if ($(this).is(':checked')) {
                                r.prop('checked', true);
                            } else {
                                r.prop('checked', false);
                            }
                        });
                        ClassicEditor
                            .create(document.querySelector('#msg'), {
                                toolbar: ['bold', 'italic','Heading', 'Link', 'bulletedList', 'numberedList', 'blockQuote']
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    });

                </script>
                @else
                <div class="panel-body">
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        該課程尚無學員，請先<a href="{{ url('register/student') }}">新增學員</a>。
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
