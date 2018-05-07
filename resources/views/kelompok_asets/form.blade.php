<div class="form-group {{ $errors->has('kodeKelompokAset') ? 'has-error' : ''}}">
    {!! Form::label('kodeKelompokAset', 'Kodekelompokaset', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeKelompokAset', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeKelompokAset', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('masapakai') ? 'has-error' : ''}}">
    {!! Form::label('masapakai', 'Masapakai', ['class' => 'col-md-4 control-label']) !!}
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
