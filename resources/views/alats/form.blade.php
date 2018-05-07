<div class="form-group {{ $errors->has('kodeAlat') ? 'has-error' : ''}}">
    {!! Form::label('kodeAlat', 'Kode Alat', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeAlat', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeAlat', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('Satuan') ? 'has-error' : ''}}">
    {!! Form::label('Satuan', 'Satuan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('Satuan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('satuan', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('kelompokUtilitas') ? 'has-error' : ''}}">
    {!! Form::label('kelompokUtilitas', 'Kelompok Utilitas', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kelompokUtilitas', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kelompokUtilitas', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('Keterangan') ? 'has-error' : ''}}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('keterangan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('masapakai') ? 'has-error' : ''}}">
    {!! Form::label('masapakai', 'Masa Pakai', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('masapakai', null, ['class' => 'form-control']) !!}
        {!! $errors->first('masapakai', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
