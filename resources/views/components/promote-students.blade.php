<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
<div class="table-responsive">
    <form action="{{ url('school/promote-students') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="section_id" value="{{ $section_id }}">
        <table class="table table-bordered table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">學號</th>
                    <th scope="col">姓名</th>
                    <th scope="col">停權(離開文教機構)</th>
                    <th scope="col">開始(年)</th>
                    <th scope="col">結束(年)</th>
                    <th scope="col">課程切換</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key=>$student)
                <tr>
                    <td>{{ $student->student_code }}</td>
                    <td>
                        <a href="{{ url('student/'.$student->student_code) }}">{{ $student->name }}</a>
                    </td>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="left_school{{ $loop->index }}">
                            </label>
                        </div>
                    </td>
                    <td>
                        {{ $student->studentInfo['session'] }}
                    </td>
                    <td>
                        <input class="form-control datepicker" name="to_session[]" value="{{ date('Y', strtotime('+1 year')) }}">
                    </td>
                    <td>
                        <select id="to_section" class="form-control" name="to_section[]">
                            <option value="0">清除課程</option>
                            @foreach($classes as $class)
                                @foreach($class->sections as $section)
                                    @if($section_id == $section->id)
                                        <option value="{{ $section->id }}" selected="selected">
                                            {{ $class->class_number }} - {{ $section->section_number }}
                                        </option>
                                    @else
                                        <option value="{{ $section->id }}">
                                            {{ $class->class_number }} - {{ $section->section_number }}
                                        </option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="text-align:right;">
            <input type="submit" class="btn btn-primary" value="更改">
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
