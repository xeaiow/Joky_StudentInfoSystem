<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    <label for="title" class="col-md-4 control-label">書名</label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="書名" required>

        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
    <label for="about" class="col-md-4 control-label">關於</label>

    <div class="col-md-6">
        <textarea rows="3" id="about" type="text" class="form-control" name="about" value="{{ old('about') }}" placeholder="關於" required></textarea>

        @if ($errors->has('about'))
            <span class="help-block">
                <strong>{{ $errors->first('about') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('book_code') ? ' has-error' : '' }}">
    <label for="book_code" class="col-md-4 control-label">書籍編號</label>

    <div class="col-md-6">
        <input id="book_code" type="text" class="form-control" name="book_code" value="{{ old('book_code') }}" placeholder="書籍編號" required>

        @if ($errors->has('book_code'))
            <span class="help-block">
                <strong>{{ $errors->first('book_code') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('author') ? ' has-error' : '' }}">
    <label for="author" class="col-md-4 control-label">作者</label>

    <div class="col-md-6">
        <input id="author" type="text" class="form-control" name="author" value="{{ old('author') }}" placeholder="作者" required>

        @if ($errors->has('author'))
            <span class="help-block">
                <strong>{{ $errors->first('author') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="col-md-4 control-label">價格</label>

    <div class="col-md-6">
        <input id="price" type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="價格" required>

        @if ($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
    <label for="quantity" class="col-md-4 control-label">數量</label>

    <div class="col-md-6">
        <input id="quantity" type="number" class="form-control" name="quantity" value="{{ old('quantity') }}" placeholder="數量" required>

        @if ($errors->has('quantity'))
            <span class="help-block">
                <strong>{{ $errors->first('quantity') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('rackNo') ? ' has-error' : '' }}">
    <label for="rackNo" class="col-md-4 control-label">幾號架上</label>

    <div class="col-md-6">
        <input id="rackNo" type="number" class="form-control" name="rackNo" value="{{ old('rackNo') }}" placeholder="幾號架上" required>

        @if ($errors->has('rackNo'))
            <span class="help-block">
                <strong>{{ $errors->first('rackNo') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('rowNo') ? ' has-error' : '' }}">
    <label for="rowNo" class="col-md-4 control-label">第幾排</label>

    <div class="col-md-6">
        <input id="rowNo" type="number" class="form-control" name="rowNo" value="{{ old('rowNo') }}" placeholder="第幾排" required>

        @if ($errors->has('rowNo'))
            <span class="help-block">
                <strong>{{ $errors->first('rowNo') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('img_path') ? ' has-error' : '' }}">
    <label for="img_path" class="col-md-4 control-label">書本封面網址</label>

    <div class="col-md-6">
        <input id="img_path" type="text" class="form-control" name="img_path" value="{{ old('img_path') }}" placeholder="書本封面網址" required>

        @if ($errors->has('img_path'))
            <span class="help-block">
                <strong>{{ $errors->first('img_path') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
    <label for="type" class="col-md-4 control-label">書本類型</label>

    <div class="col-md-6">
        <select id="type" class="form-control" name="type">
            <option value="Academic">Academic</option>
            <option value="Magazine">Magazine</option>
            <option value="Story">Story</option>
            <option value="Other">Other</option>
        </select>

        @if ($errors->has('type'))
            <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
    <label for="class_id" class="col-md-4 control-label">分級</label>

    <div class="col-md-6">
        <select id="class_id" class="form-control" name="class_id">
            @foreach($classes as $class)
                <option value="{{ $class->id }}">
                    {{ $class->class_number }} {{ $class->group }}
                </option>
            @endforeach
        </select>

        @if ($errors->has('class_id'))
            <span class="help-block">
                <strong>{{ $errors->first('class_id') }}</strong>
            </span>
        @endif
    </div>
</div>
