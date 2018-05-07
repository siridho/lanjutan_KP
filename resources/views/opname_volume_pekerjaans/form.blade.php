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
</div><div class="form-group {{ $errors->has('kodeProyek') ? 'has-error' : ''}}">
    {!! Form::label('kodeProyek', 'Kodeproyek', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeProyek', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeProyek', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('idKaryawan') ? 'has-error' : ''}}">
    {!! Form::label('idKaryawan', 'Idkaryawan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('idKaryawan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('idKaryawan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status_nota') ? 'has-error' : ''}}">
    {!! Form::label('status_nota', 'Status Nota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('status_nota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('status_nota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('validator') ? 'has-error' : ''}}">
    {!! Form::label('validator', 'Validator', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('validator', null, ['class' => 'form-control']) !!}
        {!! $errors->first('validator', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('waktu_valid') ? 'has-error' : ''}}">
    {!! Form::label('waktu_valid', 'Waktu Valid', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('waktu_valid', null, ['class' => 'form-control']) !!}
        {!! $errors->first('waktu_valid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
