<div class="form-group {{ $errors->has('kodePengeluaran') ? 'has-error' : ''}}">
    {!! Form::label('kodePengeluaran', 'kodePengeluaran', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodePengeluaran', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodePengeluaran', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('satuan') ? 'has-error' : ''}}">
    {!! Form::label('satuan', 'Satuan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('satuan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('satuan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('keterangan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
