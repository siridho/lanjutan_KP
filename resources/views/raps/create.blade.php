@extends('layouts.template')

@section('title','Data RAP')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Data RAP</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/raps', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <input type="hidden" name="status" value="menunggu">
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No RAP </td>
                                        @if(!isset($rap))
                                            <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota" value="{{substr($kode,7)}}"></td>
                                        @else
                                            <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota" value="{{substr($rap->nonota,6)}}"></td>
                                        @endif
                                        
                                        <td width="100px" align="right" style="padding-right:10px; "> Pilih Pekerjaan </td>
                                        <td width="200px"><select required class='pekerjaan form-control' name='pekerjaan' id='pekerjaan' onchange='setsatuan(this)'>
                                                <option value=""> -- Pilih Pekerjaan -- </option>
                                                        @foreach ($pekerjaans as $pekerjaan)
                                                           <option value='{{ $pekerjaan->kodeKelompokKegiatan }}'> {{ $pekerjaan->kodeKelompokKegiatan }} - {{$pekerjaan -> nama}}  </option>
                                                        @endforeach
                                                    </select>
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal RAP </td>
                                        @if(!isset($rap))
                                            <td width="200px"><input class="form-control date-picker birthday" type="text" required name="tglNota" ></td>
                                        @else
                                        @php
                                            $tglrap=date_create($rap->tglNota);
                                            $tglrap=date_format($tglrap,'m/d/Y');
                                        @endphp
                                            <td width="200px"><input class="form-control date-picker birthday" type="text" required name="tglNota" value="{{$tglrap}}" ></td>
                                        @endif
                                        <td width="100px" align="right"  style="padding-right:10px;">Keterangan</td>
                                        <td width="200px">
                                            @if(!isset($rap))
                                                 <input type="text" required name="keterangan" class="form-control">
                                            @else
                                                 <input type="text" required name="keterangan" class="form-control" value="">
                                            @endif
                                           
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                            @foreach($proyeks as $proyek)
                                                {{$proyek->uraian}}
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <th>Jenis Kegiatan</th>
                                            <th>Minggu Mulai</th>
                                            <th>Lama</th>
                                            <th>Volume Kegiatan</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Kegiatan</th>
                                            <th>Detail</th> 
                                            <th>Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id='detail'>
                                            
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <td></td>
                                                <td></td>
                                                <td colspan="3" align="right" style="font-size: 1.3em; vertical-align: middle;"> TOTAL KEGIATAN</td>
                                                <td colspan="2">
                                                    <b><input type="text" class='form-control' readonly value=0 name="grandTot" id="grandTot"></b>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8"><a href='#' class='btn btn-default pull-right' id='tambah' align='right'> Tambah </a></td>
                                            </tr>
                                            <tr>
                                                   <td colspan="2"><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN </button></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                             
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                            {!! Form::close() !!}


                            <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" width="100%">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form class="form-horizontal" method="post" id="modalser">

                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Tambah Detail Biaya RAP</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                     <thead>
                                                        <th>Jenis Biaya</th>
                                                        <th>Volume Biaya</th>
                                                        <th>Satuan</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Total Biaya</th>
                                                        <th>Aksi</th>                                         
                                                    </thead>
                                                    <input type="hidden" name="noBarisModal" id="noBarisModal" value="0"> 
                                                    <input type="hidden" name="noBiaya" id="noBiaya" value="0"> 
                                                    <tbody id='detailBiaya'>
                                                        
                                                    </tbody>  
                                                    <tfoot>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td colspan="2" align="right" style="font-size: 1.3em; vertical-align: middle;">SUBTOTAL BIAYA</td>
                                                            <td><b><input type="text" class='form-control' readonly value=0 name="grandTotBiaya" id="grandTotBiaya"></b></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><a href='#' class='btn btn-default pull-right' id='tambahBiaya' align='right'> Tambah </a></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" onclick="simpanBiaya(this)">Simpan</button>
                                                
                                               <!-- <button type="button" class="btn btn-primary">Delete Data</button> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                          

<script type="text/javascript"> 

$body = $("body")

$(document).ready( function ()
{
    $('#tambah').click(function(e){
        e.preventDefault()
        var itung=$("#no").val();   
        // var urut=$('#urut').val();   
        
        itung++;
        var baris = "<tr id='no"+itung+"'>"+
                        "<td width='20%'>"+
                        "<select class='kodeKelompokKegiatan form-control' name='kodeKelompokKegiatan[]' id='kodeKelompokKegiatan"+itung+"' required onchange='setsatuan(this)'>"+
                        "<option value=''> -- Pilih Kegiatan -- </option>"+
                                @foreach ($kegiatans as $kegiatan)
                                   "<option value='{{ $kegiatan->kodeKelompokKegiatan }}'> {{ $kegiatan->kodeKelompokKegiatan }} - {{$kegiatan -> nama}}  </option>"+
                                @endforeach
                            "</select>"+
                        "</td>"+
                        "<td width='' align='right' style='padding-right:10px;'><input type='number' min='1' name='minggu_mulai[]' class='minggu_mulai form-control' id='minggu_mulai"+itung+"' value='1' ></td>"+
                        "<td width=''><input type='number' name='lama[]' class='lama form-control' id='lama"+itung+"'  min='1' value='1'  onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")' ></td>"+
                        "<td width=''><input type='number' min='0' step='any' name='volume[]' id='volume"+itung+"' class='form-control volume' onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")' ></td>"+
                        "<td width='' id='satuan"+itung+"' ></td>"+
                        "<td width=''><input type='number' step='any' name='hargaSat[]' id='hargaSat"+itung+"' class='harsat form-control' readonly></td>"+
                        "<td width=''><input type='number' step='any' name='total[]' id='total"+itung+"' class='form-control total' readonly></td>"+
                        "<td width='5%'><button  class='btn btn-primary fa fa-eye' data-toggle='modal' data-target='#mymodal' onclick='setModal("+itung+",event)' data-title='Lihat Detail'></button></td>"+
                        "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                        "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });

    $('#tambahBiaya').click(function(e){
        e.preventDefault()
        var itung=$("#noBiaya").val();
        // var urut=$('#urut').val();
        
        itung++;
        var baris = "<tr id='noBiaya"+itung+"'>"+
                        "<td width='20%'>"+
                        "<select class='kodeJenisBiaya form-control' name='kodeJenisBiaya[]' id='kodeJenisBiaya"+itung+"'  onchange='setsatuanbiaya(this)'>"+
                        "<option> -- Pilih Jenis Biaya -- </option>"+
                                @foreach ($biayas as $biaya)
                                   "<option value='{{ $biaya->kodeJenisBiaya }}'> {{ $biaya->kodeJenisBiaya }} - {{$biaya -> nama}}  </option>"+
                                @endforeach
                            "</select>"+
                        "</td>"+

                        "<td width='' align='right' style='padding-right:10px;'><input type='number' min='1' name='volumeBiaya[]' class='volumeBiaya form-control' id='volumeBiaya"+itung+"' value='1'  onkeyup='getTotalBiaya("+itung+")' onchange='getTotalBiaya("+itung+")'></td>"+
                        "<td width='' id='satuanBiaya"+itung+"'></td>"+
                        "<td width=''><input type='number' step='any' name='hargaSatBiaya[]' id='hargaSatBiaya"+itung+"' class='form-control' onkeyup='getTotalBiaya("+itung+")' onchange='getTotalBiaya("+itung+")' ></td>"+
                        "<td width=''><input type='number' step='any' name='totalBiaya[]' id='totalBiaya"+itung+"' class='form-control' readonly></td>"+
                        "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapusBiaya(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                    "</tr>";
        $('#detailBiaya').append(baris);
        $('#noBiaya').val(itung);
    });
   
    
});

function setsatuan(param){
    var val = param.value;
    var temp = param.id;
    var itung = $("#no").val();
    var split = temp.split('kodeKelompokKegiatan');
    var id = split[1]

    var url = "../getsatuankelompokkegiatan/"+val
    
    $.get(url, function(data){
        $('#satuan'+id).html(data)

    })
}

function setsatuanbiaya(param){
    var val = param.value;
    var temp = param.id;
    var itung = $("#no").val();

    var split = temp.split('kodeJenisBiaya');
    var id = split[1]

    var url = "../getsatuanbiaya/"+val
    $.get(url, function(data){
        $('#satuanBiaya'+id).html(data)
    })
}

function setModal(param, e){
    e.preventDefault()
    $('#detailBiaya').html('')
    $('#noBarisModal').val(param)  

    var val = param
    // alert(param)

    var url = "../getisimodal/"+val
    $.get(url, function(data){
        var obj = JSON.parse(data)

        // for(var i=0; i<obj.kodeJenisBiaya.length; i++)
        //     console.log('kodeJenisBiaya'+i+'='+obj.kodeJenisBiaya[i])

        // for(var i=0; i<obj.volumeBiaya.length; i++)
        //     console.log('volumeBiaya'+i+'='+obj.volumeBiaya[i])

        itung = 1
        for(var i=0; i<obj.volumeBiaya.length; i++){
            
            var baris = "<tr id='noBiaya"+itung+"'>"+
                        "<td width='20%'>"+
                        "<select class='kodeJenisBiaya form-control' name='kodeJenisBiaya[]' id='kodeJenisBiaya"+itung+"'  onchange='setsatuanbiaya(this)'>"+
                        "<option> -- Pilih Jenis Biaya -- </option>"+
                            
                                @foreach ($biayas as $biaya)
                                        "<option value='{{ $biaya->kodeJenisBiaya }}'> {{ $biaya->kodeJenisBiaya }} - {{$biaya -> nama}}  </option>"+
                                @endforeach
                            "</select>"+
                        "</td>"+

                        "<td width='' align='right' style='padding-right:10px;'><input type='number' min='1' name='volumeBiaya[]' class='volumeBiaya form-control' id='volumeBiaya"+itung+"' value='"+obj.volumeBiaya[i]+"'  onkeyup='getTotalBiaya("+itung+")' onchange='getTotalBiaya("+itung+")'></td>"+
                        "<td width='' id='satuanBiaya"+itung+"'>"+obj.satuan[i]+"</td>"+
                        "<td width=''><input type='number' value='"+obj.hargaSatBiaya[i]+"' step='any' name='hargaSatBiaya[]' id='hargaSatBiaya"+itung+"' class='form-control' onkeyup='getTotalBiaya("+itung+")' onchange='getTotalBiaya("+itung+")' ></td>"+
                        "<td width=''><input type='number' step='any' name='totalBiaya[]' id='totalBiaya"+itung+"' class='form-control' value='"+obj.totalBiaya[i]+"' readonly></td>"+
                        "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapusBiaya(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                    "</tr>";
                    
                    $('#detailBiaya').append(baris)
                    document.getElementById('kodeJenisBiaya'+itung).value = obj.kodeJenisBiaya[i]
                    
                    itung++
        }
        getGrandTotalBiaya()         
    })

}

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}
function hapusBiaya(param, e){
    e.preventDefault()
    $('#noBiaya'+param.id).remove();
    getGrandTotalBiaya()

    // return false;
}

function getTotal(no){
    var tot = $('#hargaSat'+no).val()
    var vol = $('#volume'+no).val()
    document.getElementById('total'+no).value = tot * vol
 
    getGrandTotal()
}
function getTotalBiaya(no){
    var volumeBiaya = $("#volumeBiaya"+no).val();
    
    var hargaSatBiaya = $('#hargaSatBiaya'+no).val();
    var totalBiaya = volumeBiaya * hargaSatBiaya;
    $('#totalBiaya'+no).val(totalBiaya);
    getGrandTotalBiaya();
}

function getGrandTotal(){
    var arraytotal = document.getElementsByClassName('total');
    
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }

    document.getElementById('grandTot').value = tot;
}

function getGrandTotalBiaya(){
    var arraytotalbiaya = document.getElementsByName('totalBiaya[]');
    var totbiaya=0;
    for(var i=0;i<arraytotalbiaya.length;i++){
        if(parseInt(arraytotalbiaya[i].value))
            totbiaya += parseInt(arraytotalbiaya[i].value);
    }

    document.getElementById('grandTotBiaya').value = totbiaya;
}

function simpanBiaya(){
    // var kodeJenisBiaya = document.getElementsByName('kodeJenisBiaya[]');
    // var volumeBiaya = document.getElementsByName('volumeBiaya[]');
    // var hargaSatBiaya = document.getElementsByName('hargaSatBiaya[]');
    // var totalBiaya = document.getElementsByName('totalBiaya[]');
    // var grandTotBiaya = document.getElementsByName('grandTotBiaya');

    var no = document.getElementById('noBarisModal')
    
    var str = $('#modalser').serialize();

    $body.addClass("loading");
    var url="../setsessionbiaya" 
    $.post(url, str, function(data){
            document.getElementById('hargaSat'+no.value).value = data 
            document.getElementById('total'+no.value).value = data * $('#volume'+no.value).val()
            getGrandTotal()

            $body.removeClass("loading");
    })    

    
    $('#mymodal').modal('hide');

    
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