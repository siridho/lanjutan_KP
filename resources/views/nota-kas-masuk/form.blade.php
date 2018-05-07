<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_karyawan') ? 'has-error' : ''}}">
    {!! Form::label('id_karyawan', 'Id Karyawan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('id_karyawan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('id_karyawan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tglNota') ? 'has-error' : ''}}">
    {!! Form::label('tglNota', 'Tglnota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tglNota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tglNota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kodeProyek') ? 'has-error' : ''}}">
    {!! Form::label('kodeProyek', 'Kodeproyek', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeProyek', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeProyek', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('validator') ? 'has-error' : ''}}">
    {!! Form::label('validator', 'Validator', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('validator', null, ['class' => 'form-control']) !!}
        {!! $errors->first('validator', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('referensi') ? 'has-error' : ''}}">
    {!! Form::label('referensi', 'Referensi', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('referensi', null, ['class' => 'form-control']) !!}
        {!! $errors->first('referensi', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
