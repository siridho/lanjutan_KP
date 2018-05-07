<div class="form-group {{ $errors->has('no') ? 'has-error' : ''}}">
    {!! Form::label('no', 'No', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('no', null, ['class' => 'form-control']) !!}
        {!! $errors->first('no', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_karyawan') ? 'has-error' : ''}}">
    {!! Form::label('id_karyawan', 'Id Karyawan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('id_karyawan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('id_karyawan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('keterangan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
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
