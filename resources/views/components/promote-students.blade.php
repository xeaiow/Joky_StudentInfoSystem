<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
<div class="table-responsive">
    <form action="{{url('school/promote-students')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="section_id" value="{{$section_id}}">
        <table class="table table-bordered table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">學號</th>
                    <th scope="col">姓名</th>
                    <th scope="col">離校</th>
                    <th scope="col">時間從</th>
                    <th scope="col">到時間</th>
                    <th scope="col">從課程</th>
                    <th scope="col">到課程</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key=>$student)
                <tr>
                    <th scope="row">{{ ($loop->index + 1) }}</th>
                    <td><small>{{$student->student_code}}</small></td>
                    <td>
                        <small><a href="{{url('student/'.$student->student_code)}}">{{$student->name}}</a></small>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="left_school{{$loop->index}}"> Left
                            </label>
                        </div>
                    </td>
                    <td>
                        <small>{{$student->studentInfo['session']}}</small>
                    </td>
                    <td>
                        <input class="form-control datepicker" name="to_session[]"
                            value="{{date('Y', strtotime('+1 year'))}}">
                    </td>
                    <!-- <td style="text-align: center;">
                        <small>Class: {{$student->section->class->class_number}} - Section:
                            {{$student->section->section_number}}</small>
                    </td> -->
                    <td>
                        <select id="to_section" class="form-control" name="to_section[]">
                            @foreach($classes as $class)
                            @foreach($class->sections as $section)
                            <option value="{{$section->id}}">
                                Class: {{$class->class_number}} -
                                Section: {{$section->section_number}}
                            </option>
                            @endforeach
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align:right;">
            <input type="submit" class="btn btn-primary" value="確定">
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('.datepicker').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    })

</script>
