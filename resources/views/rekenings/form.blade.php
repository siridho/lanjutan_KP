<div class="form-group {{ $errors->has('kode') ? 'has-error' : ''}}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kode', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('norek') ? 'has-error' : ''}}">
    {!! Form::label('norek', 'Norek', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('norek', null, ['class' => 'form-control']) !!}
        {!! $errors->first('norek', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('namabank') ? 'has-error' : ''}}">
    {!! Form::label('namabank', 'Namabank', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('namabank', null, ['class' => 'form-control']) !!}
        {!! $errors->first('namabank', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
