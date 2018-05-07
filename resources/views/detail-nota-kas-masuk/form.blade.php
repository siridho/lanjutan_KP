<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('uraian') ? 'has-error' : ''}}">
    {!! Form::label('uraian', 'Uraian', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('uraian', null, ['class' => 'form-control']) !!}
        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('noBaris') ? 'has-error' : ''}}">
    {!! Form::label('noBaris', 'Nobaris', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('noBaris', null, ['class' => 'form-control']) !!}
        {!! $errors->first('noBaris', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('saldo') ? 'has-error' : ''}}">
    {!! Form::label('saldo', 'Saldo', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('saldo', null, ['class' => 'form-control']) !!}
        {!! $errors->first('saldo', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
