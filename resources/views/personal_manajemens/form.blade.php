<div class="form-group {{ $errors->has('kodePersonalManajemen') ? 'has-error' : ''}}">
    {!! Form::label('kodePersonalManajemen', 'Kodepersonalmanajemen', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodePersonalManajemen', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodePersonalManajemen', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
    {!! Form::label('alamat', 'Alamat', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('alamat', null, ['class' => 'form-control']) !!}
        {!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nomoridentitas') ? 'has-error' : ''}}">
    {!! Form::label('nomoridentitas', 'Nomoridentitas', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nomoridentitas', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nomoridentitas', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('bagian') ? 'has-error' : ''}}">
    {!! Form::label('bagian', 'Bagian', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('bagian', null, ['class' => 'form-control']) !!}
        {!! $errors->first('bagian', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jabatan') ? 'has-error' : ''}}">
    {!! Form::label('jabatan', 'Jabatan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('jabatan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jabatan', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
