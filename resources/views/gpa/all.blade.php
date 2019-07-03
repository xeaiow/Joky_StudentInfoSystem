@extends('layouts.app')
@section('title', '所有成績')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2" id="side-navbar">
            @include('layouts.leftside-menubar')
        </div>
        <div class="col-md-8" id="main-container">
            <div class="panel panel-default">
                <div class="page-panel-title">所有成績</div>

                <div class="panel-body">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif
                  <?php
                    $gpaName = "";
                  ?>
                  @foreach($gpas as $g)
                    <?php
                      if($g->grade_system_name != $gpaName){
                        $gpaName = $g->grade_system_name;
                      } else {
                        continue;
                      }
                    ?>
                    <h4>{{$g->grade_system_name}}</h4>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr class="success">
                            <th scope="col">級分</th>
                            <th scope="col">積分</th>
                            <th scope="col">從(分)</th>
                            <th scope="col">到(分)</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($gpas as $gpa)
                          @if($gpa->grade_system_name != $gpaName)
                            @continue
                          @endif
                          <tr>
                            <td>{{$gpa->grade}}</td>
                            <td>{{$gpa->point}}</td>
                            <td>{{$gpa->from_mark}}</td>
                            <td>{{$gpa->to_mark}}</td>
                            {{--
                            <td>
                              <form action="{{url('gpa/delete')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="gpa_id" value="{{$gpa->id}}">
                                <button class="btn btn-xs btn-success">Delete</button>
                              </form>
                            </td>--}}
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
