@extends('layouts.template')

@section('title','Tambah Opname Volume Pekerjaan')


@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Opname Volume Pekerjaan</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @php
                         $tgl=date('m/d/Y',strtotime($notaopname->tglNota));
                         $itung=1;
                        @endphp
                         {!! Form::open(['url' => ['/opname_volume_pekerjaans',$notaopname->nonota], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Opname Volume Pekerjaan </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota2" value="{{substr($notaopname->nonota,6)}}"></td>
                                        <input placeholder="Masukkan nomor nota" class="form-control" type="hidden" required readonly name="nonota" value="{{$notaopname->nonota}}">
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                            @foreach($proyeks as $proyek)
                                                {{$proyek->uraian}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota </td>
                                        <td width="200px"><input class="form-control date-picker birthday" type="text" required name="tglNota" value="{{$tgl}}" ></td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                   
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="60%">Kode Kelompok Kegiatan</th>
                                            <th width="25%">Volume Minggu Ini</th>
                                            <th width="25%">Satuan</th>
                                            <th width="15%">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="{{$details->count()}}">                                   
                                        <tbody id='detail'>
                                        @foreach($details as $item)
                                        <tr id='no{{$itung}}'>
                                                <td width='15%'>
                                                    <!-- <input id='kode1' name='kode[]' class='kode form-control'> -->
                                                    <select class="kode form-control" name='kode[]' id='kode{{$itung}}' onchange='setsatuan(this)'>
                                                        <option> -- Pilih Kode -- </option>
                                                        @foreach($kelompokKegiatans as $apa)
                                                            @if($apa->kodeKelompokKegiatan==$item->kodeKelompokKegiatan)
                                                            <option value="{{$item->kodeKelompokKegiatan}}" selected>{{$apa->nama}} ({{$apa->kodeKelompokKegiatan}})</option>
                                                            @else
                                                            <option value="{{$item->kodeKelompokKegiatan}}">{{$apa->nama}} ({{$apa->kodeKelompokKegiatan}})</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td width='25%'><input type='number' min='0' step='any' required name='volume[]' id='volume{{$itung}}' value="{{$item->volume}}" class='form-control'></td>
                                                <td width='5%' id='satuan{{$itung}}'>{{$item->kelompokkegiatan->satuan}}</td>
                                                <td width='15%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='{{$itung}}'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>
                                                @php
                                                $itung++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                
                                                <td></td>
                                                <td style="font-size: 1.3em; vertical-align: middle; text-align: right;"></td>
                                                <td>
                                                </td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                            <tr>
                                               
                                                <td><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a></td>
                                                <td></td>
                                                <td><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN </button></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                            {!! Form::close() !!}


<script type="text/javascript"> 
 $(document).ready( function ()
{
    $('#tambah').click(function(e){
        e.preventDefault()
        var itung=$("#no").val();
        // var urut=$('#urut').val();
        
        itung++;
        var baris = "<tr id='no"+itung+"'>"+
                                                "<td width='60%'>"+
                                                     "<select class='kode form-control' name='kode[]' id='kode"+itung+"' onchange='setsatuan(this)'><option> -- Pilih Kode -- </option>"+
                                                        @foreach($kelompokKegiatans as $item)
                                                           " <option value='{{$item->kodeKelompokKegiatan}}'>{{$item->nama}} ({{$item->kodeKelompokKegiatan}})</option>"+
                                                        @endforeach
                                                   "</select>"+
                                                "</td>"+
                                                "<td width='25%'><input type='number' min='0' required step='any' name='volume[]' id='volume"+itung+"' class='form-control' ></td>"+
                                                "<td width='5%' id='satuan"+itung+"'></td>"+
                                                "<td width='15%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });
    $('#norek').hide();

    
});



function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function setsatuan(param){
    var val=param.value;
    var temp=param.id;
    var itung=$("#no").val();
    var split=temp.split('kode');
    var id=split[1]

// alert(id)
    
         @foreach($kelompokKegiatans as $item)
            if(val=="{{ $item->kodeKelompokKegiatan }}"){
                $("#satuan"+id).html("{{$item->satuan}}")
            }
         @endforeach
    



   
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
