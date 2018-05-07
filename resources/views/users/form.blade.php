<div class="form-group {{ $errors->has('username') ? 'has-error' : ''}}">
    {!! Form::label('username', 'Username', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('username', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('username', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::email('email', null, ['class' => 'form-control','required']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      <input type="password" id="password" name="password" class="form-control" required>
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {!! Form::label('repassword', 'Ulangi password', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
      <input type="password" id="password_confirmation" type="password" class="form-control" name="password_confirmation" onkeyup="cekpass(this)" required>
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
    <div id="messagepass" class="col-md-1 label label-warning">Ulangi Password Salah</div>
</div>
<div class="form-group {{ $errors->has('level') ? 'has-error' : ''}}">
    {!! Form::label('level', 'Level', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       <select name="level" id="level" class="form-control" required>
           <option value="">-- Pilih Jabatan -- </option>
           <option value="Admin">Admin</option>
           <option value="Manager Proyek">Manager Proyek</option>
           <option value="Kasir">Kasir</option>
           <option value="Bendahara">Bendahara</option>
       </select>
        {!! $errors->first('level', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Tambah', ['class' => 'btn btn-primary','id'=>'btn']) !!}
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#messagepass').hide()
    })
    
    document.getElementById('level').value='{{$user->level or ""}}'
    @if(isset($user))
    $('#password').removeAttr('required')
    $('#password_confirmation').removeAttr('required')
    @endif

    function cekpass(param){
        if(param.value!==$('#password').val()){
            $('#messagepass').show()
            $('#btn').attr('disabled',true)
        }else{
            $('#messagepass').hide()
            $('#btn').removeAttr('disabled')
        }
    }
</script>
