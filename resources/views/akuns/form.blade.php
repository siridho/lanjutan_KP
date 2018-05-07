<div class="form-group {{ $errors->has('noakun') ? 'has-error' : ''}}">
    {!! Form::label('noakun', 'Noakun', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('noakun', null, ['class' => 'form-control']) !!}
        {!! $errors->first('noakun', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('namaakun') ? 'has-error' : ''}}">
    {!! Form::label('namaakun', 'Namaakun', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('namaakun', null, ['class' => 'form-control']) !!}
        {!! $errors->first('namaakun', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    {!! Form::label('status', 'Status', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('status', null, ['class' => 'form-control']) !!}
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
