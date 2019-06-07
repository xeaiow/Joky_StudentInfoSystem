<form class="form-horizontal" action="{{url('exams/create')}}" method="post">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
        <label for="term" class="col-md-4 control-label">考試規則</label>

        <div class="col-md-6">
            <select id="term" class="form-control" name="term">
               <option value="1">規則 1</option>
               <option value="2">規則 2</option>
               <option value="3">規則 3</option>
            </select>

            @if ($errors->has('term'))
                <span class="help-block">
                    <strong>{{ $errors->first('term') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
        <label for="exam_name" class="col-md-4 control-label">試卷名稱</label>

        <div class="col-md-6">
            <input id="exam_name" type="text" class="form-control" name="exam_name" value="{{ old('exam_name') }}" required>

            @if ($errors->has('exam_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('exam_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
        <label for="start_date" class="col-md-4 control-label">開始日期</label>

        <div class="col-md-6">
            <input id="start_date" type="text" class="form-control" name="start_date" value="{{ old('start_date') }}" required>

            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
        <label for="end_date" class="col-md-4 control-label">結束日期</label>

        <div class="col-md-6">
            <input id="end_date" type="text" class="form-control" name="end_date" value="{{ old('end_date') }}" required>

            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('classes') ? ' has-error' : '' }}">
        <label for="classes" class="col-md-4 control-label">適用班級</label>

        <div class="col-md-6">
            @foreach ($classes as $class)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="classes[]" value="{{$class->id}}"> {{$class->class_number}}
                    </label>
                </div>
            @endforeach

            @if ($errors->has('classes'))
                <span class="help-block">
                    <strong>{{ $errors->first('classes') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <a href="javascript:history.back()" class="btn btn-danger" style="margin-right: 2%;" role="button">取消</a>
            <button type="submit" class="btn btn-success">確定</button>
        </div>
    </div>
</form>
