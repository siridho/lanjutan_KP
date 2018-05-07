<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tglNota') ? 'has-error' : ''}}">
    {!! Form::label('tglNota', 'Tglnota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tglNota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tglNota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('noBaris') ? 'has-error' : ''}}">
    {!! Form::label('noBaris', 'Nobaris', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('noBaris', null, ['class' => 'form-control']) !!}
        {!! $errors->first('noBaris', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kodeKelompokKegiatan') ? 'has-error' : ''}}">
    {!! Form::label('kodeKelompokKegiatan', 'Kodekelompokkegiatan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeKelompokKegiatan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeKelompokKegiatan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('volume') ? 'has-error' : ''}}">
    {!! Form::label('volume', 'Volume', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('volume', null, ['class' => 'form-control']) !!}
        {!! $errors->first('volume', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
