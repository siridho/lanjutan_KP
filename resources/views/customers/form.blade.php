<div class="form-group {{ $errors->has('kodeCustomer') ? 'has-error' : ''}}">
    {!! Form::label('kodeCustomer', 'Kode Customer', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeCustomer', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeCustomer', '<p class="help-block">:message</p>') !!}
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
        {!! Form::textarea('alamat', null, ['class' => 'form-control','rows'=>'3','style'=>'resize:none']) !!}
        {!! $errors->first('alamat', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('area') ? 'has-error' : ''}}">
    {!! Form::label('area', 'Area', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('area', null, ['class' => 'form-control','rows'=>'3','style'=>'resize:none']) !!}
        {!! $errors->first('area', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('telepon') ? 'has-error' : ''}}">
    {!! Form::label('telepon', 'Telepon', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('telepon', null, ['class' => 'form-control']) !!}
        {!! $errors->first('telepon', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::email('email', null, ['class' => 'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('npwp') ? 'has-error' : ''}}">
    {!! Form::label('npwp', 'Npwp', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('npwp', null, ['class' => 'form-control']) !!}
        {!! $errors->first('npwp', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kontakNama') ? 'has-error' : ''}}">
    {!! Form::label('kontakNama', 'Kontak Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kontakNama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kontakNama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kontakTelepon') ? 'has-error' : ''}}">
    {!! Form::label('kontakTelepon', 'Kontak Telepon', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kontakTelepon', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kontakTelepon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
