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
</div><div class="form-group {{ $errors->has('kodeMitra') ? 'has-error' : ''}}">
    {!! Form::label('kodeMitra', 'Kodemitra', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeMitra', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeMitra', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
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
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
