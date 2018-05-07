<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kode_material') ? 'has-error' : ''}}">
    {!! Form::label('kode_material', 'Kode Material', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kode_material', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kode_material', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
    {!! Form::label('qty', 'Qty', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('qty', null, ['class' => 'form-control']) !!}
        {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('harga') ? 'has-error' : ''}}">
    {!! Form::label('harga', 'Harga', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('harga', null, ['class' => 'form-control']) !!}
        {!! $errors->first('harga', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
