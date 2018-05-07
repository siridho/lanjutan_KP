<div class="form-group {{ $errors->has('kode_alat') ? 'has-error' : ''}}">
    {!! Form::label('kode_alat', 'Kode Alat', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control" name="kode_alat">
            <option value=''>-- Pilih Alat --</option>
            @foreach($alats as $alat)
                <option value='{{$alat->kodeAlat}}'> {{$alat->kodeMitra}} - {{$alat->nama}} </option>
            @endforeach
        </select>
    </div>
</div><div class="form-group {{ $errors->has('kode_mitra') ? 'has-error' : ''}}">
    {!! Form::label('kode_mitra', 'Kode Mitra', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control" name="kode_mitra">
            <option value=''>-- Pilih Mitra Kerja --</option>
            @foreach($mitras as $mitra)
                <option value='{{$mitra->kodeMitra}}'> {{$mitra->kodeMitra}} - {{$mitra->nama}} </option>
            @endforeach
        </select>
    </div>
</div><div class="form-group {{ $errors->has('harga_satuan') ? 'has-error' : ''}}">
    {!! Form::label('harga_satuan', 'Harga Satuan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('harga_satuan', null, ['class' => 'form-control']) !!}
        {!! $errors->first('harga_satuan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('janka_bayar') ? 'has-error' : ''}}">
    {!! Form::label('janka_bayar', 'Janka Bayar', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('jangka_bayar', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jangka_bayar', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
