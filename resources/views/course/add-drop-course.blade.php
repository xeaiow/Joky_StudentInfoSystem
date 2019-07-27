@extends('layouts.app')

@section('title', '加退選課程')

@section('content')

<style>
.dropdown-menu li a:hover, .notFoundCourse button:hover {
  color: #000 !important;
}
#course_lists {
  padding: 15px;
}
.focus, .dropCourse {
  cursor: pointer;
}
</style>

<div class="container{{ (\Auth::user()->role == 'master')? '' : '-fluid' }}">
    <div class="row">
        @if(\Auth::user()->role != 'master')
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        @endif
        <div class="col-md-10" id="main-container">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
            @endif
          <div class="col-md-6">
            <div class="card border-primary" style="margin-top: 20px;">
              <div class="card-header">學員當前課程</div>
              <div class="card-body" id="currentCourse">
                @foreach($courses as $course)
                <div class="btn-group" id="course-{{ $course->courseId }}">
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ $course->course_name }} <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropCourse" id="{{ $course->courseId }}">退選</a></li>
                  </ul>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card border-primary" style="margin-top: 20px;">
              <div class="card-header">加選課程</div>
              <div class="card-body">
              <div class="input-group">
                <input type="text" id="tags" class="form-control" placeholder="輸入班級名稱搜尋" />
                <span class="input-group-btn">
                  <button class="btn btn-primary" id="search_course" type="button">搜尋</button>
                </span>
              </div>
            </div>
            <div id="course_lists"></div>
          </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" rel="stylesheet" />
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />
<script>

  $( "#tags" ).autocomplete({
    source: function( request, response ) {
        $.ajax({
            dataType: "json",
            type : 'get',
            url: "{{ url('courses/keywordGetCourse') }}" + '/' + request.term,
            success: function(data) {
                $('#tags').removeClass('ui-autocomplete-loading');  

                response($.map( data, function(item) {
                    return item.course_name;
                }));
            },
            error: function(data) {
                $('#tags').removeClass('ui-autocomplete-loading');  
            }
        });
    },
    minLength: 2,
    open: function() {},
    close: function() {},
    focus: function(event,ui) {},
    select: function(event, ui) {}
});

$("#search_course").click(function () {
  $.ajax({
      dataType: "json",
      type : 'get',
      url: "{{ url('courses/getCourse') }}" + '/' + $("#tags").val(),
      success: function(data) {
        if (data.length != 0) {
          $("#course_lists").text('');
          $.map(data, function(item) {
            $("#course_lists").append(
              '<div class="card">'+
                '<div class="card-body">'+
                  '<h4 class="card-title">' + item.course_name + '</h4>'+
                  '<h6 class="card-subtitle mb-2 text-muted">教師：' + item.name + ' ｜ 上課時段：' + item.course_time + '</h6>'+
                  '<a id="' + item.id + '" course="' + item.course_name + '" class="btn btn-info btn-xs addCourse">加選</a>'+
                '</div>'+
              '</div>'
            )
          });
        }
        else {
          $("#course_lists").text('');
          $("#course_lists").append(
            '<div class="alert alert-dismissible alert-light notFoundCourse">'+
              '<button type="button" class="close" data-dismiss="alert">&times;</button>沒有找到課程。</div>'
          );
        }
      },
      error: function(data) {
          
      }
  });
});

$(document).on('click','.addCourse', function(){
  let student_id = {{ $student_id }};
  let self = this;
  $.ajax({
    dataType: "json",
    type : 'POST',
    data: {
      'course_id': this.id,
      'student_id': student_id
    },
    url: "{{ url('courses/add') }}",
    success: function(data) {
      if (data.status) {
        Swal.fire({
          title: '加選成功',
          type: 'success',
          confirmButtonText: '確定'
        });
        $("#currentCourse").append(
          '<div class="btn-group" id="course-' + $(self).attr('id') + '">'+
            '<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
            $(self).attr('course') + '<span class="caret"></span>'+
            '</button>'+
            '<ul class="dropdown-menu">'+
              '<li><a class="dropCourse" id="' + $(self).attr('id') + '">退選</a></li>'+
            '</ul>'+
          '</div>'
        )
      }
      else {
        Swal.fire({
          title: '加選失敗',
          type: 'error',
          confirmButtonText: '確定'
        });
      }
    },
    error: function(data) {}
  });
});

$(document).on('click','.dropCourse', function(){
  let student_id = {{ $student_id }};
  let self = this;
  Swal.fire({
    title: '確定退選？',
    text: "退選後該學員將刪除此課程相關資料",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '是，確定',
    cancelButtonText: '取消'
  }).then((result) => {
    if (result.dismiss != "cancel") {
      $.ajax({
        dataType: "json",
        type : 'POST',
        data: {
          'course_id': this.id,
          'student_id': student_id
        },
        url: "{{ url('courses/drop') }}",
        success: function(data) {
          if (data.status) {
            Swal.fire({
              title: '退選成功',
              type: 'success',
              confirmButtonText: '確定'
            });
            $("#course-" + self.id).remove();
          }
        },
        error: function(data) {}
      }); 
    }
  });
});
</script>
@endsection