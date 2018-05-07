<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('uraian') ? 'has-error' : ''}}">
    {!! Form::label('uraian', 'Uraian', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('uraian', null, ['class' => 'form-control']) !!}
        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nilai') ? 'has-error' : ''}}">
    {!! Form::label('nilai', 'Nilai', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('nilai', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nilai', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('noBaris') ? 'has-error' : ''}}">
    {!! Form::label('noBaris', 'Nobaris', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('noBaris', null, ['class' => 'form-control']) !!}
        {!! $errors->first('noBaris', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tglNota') ? 'has-error' : ''}}">
    {!! Form::label('tglNota', 'Tglnota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tglNota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tglNota', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
