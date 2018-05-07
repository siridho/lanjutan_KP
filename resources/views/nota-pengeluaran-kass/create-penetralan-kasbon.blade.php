@extends('layouts.template')

@section('title','Tambah Transaksi Penetralan Kasbon')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Transaksi Penetralan Kasbon</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/penetralan-kasbon', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Penetralan Kasbon </td>
                                        <td width="200px"><input class="form-control" type="text" required readonly name="nonota2" value="{{substr($kode,6)}}"></td>
                                        <input placeholder="Masukkan nomor nota" class="form-control" type="hidden" required readonly name="nonota" value="{{$kode,6}}">
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                            @foreach($proyeks as $proyek)
                                                {{$proyek->uraian}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota </td>
                                        <td width="200px"><input class="form-control date-picker birthday" type="text" required name="tglNota" ></td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                   
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="20%">Referensi</th>
                                            <th width="50%">Uraian</th>
                                            <th width="25%">Harga</th>   
                                            <th width="15%">Aksi</th>                                     
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                            <tr id='no1'>
                                                <td width="20%">
                                                    <select class="form-control" id="referensi1" name="referensi[]" onchange="tampilkasbon(this)">
                                                            <option value="">--Pilih Nota Kasbon--</option>
                                                            @foreach($notakasbon as $nota)
                                                                <option value="{{$nota->nonota}}/{{$nota->noBaris}}/1">({{$nota->nonota}}) {{$nota->tglNota}}: {{$nota->uraian}}</option>
                                                            @endforeach
                                                    </select> 
                                                </td>
                                                <td width='50%'>
                                                    <textarea id='uraian1' name='uraian[]' class='uraian form-control' style='resize:none;'></textarea>
                                                </td>
                                                <td width='25%'>
                                                    <input type='text' readonly name='price[]' id='price1' class='form-control'>
                                                </td>
                                                 <td width='15%' >
                                                    <a style='background-color:#fffff; font-weight:bold; color:red;' id='1'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a>
                                                 </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    
                                    <br>

                                    <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>

                                    <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> NETRALKAN KASBON </button>

                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                            {!! Form::close() !!}


<script type="text/javascript"> 

    $(document).ready(function(){
        $('#tambah').click(function(e){
            e.preventDefault()
            var itung = $("#no").val();
            itung++;
            var baris = "<tr id='no"+itung+"'>"+
                            "<td width='20%'>"+
                            "<select class='form-control' id='referensi"+itung+"' name='referensi[]' onchange='tampilkasbon(this)'>"+
                            "<option value=''>--Pilih Nota Kasbon--</option>"+
                                @foreach($notakasbon as $nota)
                                    "<option value='{{$nota->nonota}}/{{$nota->noBaris}}/"+itung+"'>({{$nota->nonota}}) {{$nota->tglNota}}: {{$nota->uraian}}</option>"+
                                @endforeach
                            "</select> "+
                            "</td>"+
                            "<td width='50%'>"+
                               "<textarea id='uraian"+itung+"' name='uraian[]' class='uraian form-control' style='resize:none;'></textarea>"+
                            "</td>"+
                            "<td width='25%'>"+
                                "<input type='text' readonly name='price[]' id='price"+itung+"' class='form-control'>"+
                            "</td>"+
                             "<td width='15%' >"+
                                "<a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a>"+
                             "</td>"+
                        "</tr>";
            $('#detail').append(baris);
            $('#no').val(itung);
        });
    });

    function hapus(param, e){
        e.preventDefault()
        $('#no'+param.id).remove();
    }

    function tampilkasbon(param){
        var val = param.value;

        val = val.toString();
        var spl = val.split('/');
        nonota = spl[0];
        nobaris = spl[1];
        no = spl[2];
      
        var url = "loadharga/"+nonota+"/"+nobaris;
        $.get(url, function(data){
            $('#price'+no).val(data)
        }) 
    }

 </script>

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
