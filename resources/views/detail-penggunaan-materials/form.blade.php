<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kodeMaterial') ? 'has-error' : ''}}">
    {!! Form::label('kodeMaterial', 'Kodematerial', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeMaterial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeMaterial', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jumlah') ? 'has-error' : ''}}">
    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('jumlah', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jumlah', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
