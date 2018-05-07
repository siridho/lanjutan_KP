<div class="form-group {{ $errors->has('kodeGudang') ? 'has-error' : ''}}">
    {!! Form::label('kodeGudang', 'Kodegudang', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeGudang', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeGudang', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kodeMaterial') ? 'has-error' : ''}}">
    {!! Form::label('kodeMaterial', 'Kodematerial', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeMaterial', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeMaterial', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('stok') ? 'has-error' : ''}}">
    {!! Form::label('stok', 'Stok', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('stok', null, ['class' => 'form-control']) !!}
        {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
