<div class="form-group {{ $errors->has('uraian') ? 'has-error' : ''}}">
    {!! Form::label('uraian', 'Uraian', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('uraian', null, ['class' => 'form-control']) !!}
        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kode') ? 'has-error' : ''}}">
    {!! Form::label('kode', 'Kode', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kode', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kode', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('kodejpk') ? 'has-error' : ''}}">
    {!! Form::label('kodejpk', 'Kodejpk', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodejpk', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodejpk', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jumlah') ? 'has-error' : ''}}">
    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('jumlah', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jumlah', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
