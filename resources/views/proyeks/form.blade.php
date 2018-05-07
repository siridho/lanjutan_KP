<div class="form-group {{ $errors->has('kodeProyek') ? 'has-error' : ''}}">
    {!! Form::label('kodeProyek', 'Kode Proyek', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('kodeProyek', null, ['class' => 'form-control']) !!}
        {!! $errors->first('kodeProyek', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('kodeCustomer') ? 'has-error' : ''}}">
    {!! Form::label('kodeCustomer', 'Kode Customer', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control" name="kodeCustomer">
            <option value=''>-- Pilih Customer --</option>
            @foreach($customers as $customer)
                @if($proyek->kodeCustomer==$customer->kodeCustomer)
                <option value='{{$customer->kodeCustomer}}' selected> {{$customer->kodeCustomer}} - {{$customer->nama}} </option>
                @else
                <option value='{{$customer->kodeCustomer}}'> {{$customer->kodeCustomer}} - {{$customer->nama}} </option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="form-group {{ $errors->has('kodeManager') ? 'has-error' : ''}}">
    {!! Form::label('kodeManager', 'Kode Manager', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select class="form-control" name="kodeManager">
            <option value=''>-- Pilih Manager --</option>
            @foreach($managers as $manager)
             @if($proyek->id_manager==$manager->kodeManager)
               <option value='{{$manager->kodeManager}}' selected> {{$manager->kodemanager}} - {{$manager->nama}} </option>
                @else
                <option value='{{$manager->kodeManager}}'> {{$manager->kodemanager}} - {{$manager->nama}} </option>
                @endif
            
            @endforeach
        </select>
    </div>
</div>
<div class="form-group {{ $errors->has('uraian') ? 'has-error' : ''}}">
    {!! Form::label('uraian', 'Uraian', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('uraian', null, ['class' => 'form-control']) !!}
        {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jenis') ? 'has-error' : ''}}">
    {!! Form::label('jenis', 'Jenis', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('jenis', ['harian', 'borongan'], null, ['class' => 'form-control']) !!}
        {!! $errors->first('jenis', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('volume') ? 'has-error' : ''}}">
    {!! Form::label('volume', 'Volume', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('volume', null, ['class' => 'form-control']) !!}
        {!! $errors->first('volume', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('waktu') ? 'has-error' : ''}}">
    {!! Form::label('waktu', 'Waktu', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('waktu', null, ['class' => 'form-control']) !!}
        {!! $errors->first('waktu', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tanggalMulai') ? 'has-error' : ''}}">
    {!! Form::label('tanggalMulai', 'Tanggal Mulai', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tanggalMulai', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tanggalMulai', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
