@extends('layouts.template')

@section('title','Nota Terima Barang')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Nota Terima Material</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-terima-barangs', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <input type="hidden" name="status" value="menunggu">
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Transaksi Penerimaan </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota" value="{{substr($kode,6)}}"></td>
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
                                        <td width="100px" align="right" style="padding-right:10px;">Referensi</td>
                                        <td width="200px"><input type="text" name="referensi" class="form-control" ></td>

                                        
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Mitra</td>
                                        <td width="200px">
                                            <select class="form-control" id="mitra" name="kodeMitra" required>
                                            <option value="">--Pilih Mitra--</option>
                                            @foreach($mitras as $mitra)
                                                <option value="{{$mitra->kodeMitra}}">{{$mitra->nama}}</option>
                                            @endforeach
                                            </select>
                                        </td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Nota Beli</td>
                                        <td width="200px">
                                            <select class="form-control" name="notabeli" onchange="tampildetail(this)">
                                            <option value="">--Pilih Nota Beli--</option>
                                                @foreach($notabeli as $nota)
                                                    <option value="{{$nota->nonota}}">({{$nota->nonota}}) {{$nota->tglNota}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="40%">Material</th>
                                            <th width="20%">Jumlah</th>
                                            <th width="5%">Satuan</th>
                                            <th width="30%">Keterangan</th>
                                            <th width="5%">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id='detail'>
                                            
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <!-- <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td> -->
                                              
                                            </tr>
                                            <tr>
                                                <td colspan="2"><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN </button></td>
                                                <td></td>
                                                <td></td>
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
                                                "<td width='30%'>"+
                                                    "<select id='barang"+itung+"' name='barang[]' class='barang form-control'>"+"<option> -- Pilih Material -- </option>"+
                                                        @foreach ($materials as $item)
                                                           "<option value='{{ $item->kodeMaterial }}'> ({{ $item->kodeMaterial }}) {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td width='10%'><input type='number' step='any' name='qty[]' class='qty form-control' id='qty"+itung+"' min='0' value='0' onchange='getTotal("+itung+")' ></td>"+
                                                "<td width='35%'><textarea name='keterangan[]' rows='2' style='resize:none;' class='keterangan form-control' id='keterangan"+itung+"'></textarea></td>"
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });
    

   
    
});



function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function tampildetail(param) {
    var id=param.value;
    var url="../loaddetail/"+id
    $.get(url, function(data){
        $('#detail').html(data)
    })

    var url="../loadtgl/"+id
    $.get(url, function(data){
        $('#tgl').val(data)
    })    

    var url="../loadmitra/"+id
    $.get(url, function(data){
        $('#mitra').html(data)
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