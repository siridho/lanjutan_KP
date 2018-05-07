@extends('layouts.template')

@section('title','Ubah Data Nota Beli Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Nota Pembelian Material</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => ['/nota-beli-materials',$notabelimaterial->nonota], 'method' => 'PATCH', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <input type="hidden" name="status" value="menunggu">
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Transaksi Pembelian </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota" value="{{substr($notabelimaterial->nonota,6)}}"></td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                           
                                                {{$notabelimaterial->proyek->uraian}}

                                        </td>
                                    </tr>

                                    @php
                                    $tgl=date_create($notabelimaterial->tglNota);
                                    $tgl=date_format($tgl,'m/d/Y');
                                    @endphp
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota </td>
                                        <td width="200px"><input class="form-control date-picker birthday" value="{{$tgl}}" type="text" required name="tglNota" ></td>


                        

                                            <td width="100px" align="right"  style="padding-right:10px;">Referensi</td>
                                        <td width="200px">
                                            <input class="form-control" type="text"  name="cboreferensi" value="{{$notabelimaterial->referensi}}" placeholder="Masukkan Kode Referensi">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="100px" align="right"  style="padding-right:10px;">Mitra</td>
                                        <td width="200px">
                                            <select class="form-control" name="kodeMitra" required>
                                            <option value="">--Pilih Mitra--</option>
                                            @foreach($mitras as $mitra)
                                                @if($notabelimaterial->kodeMitra===$mitra->kodeMitra)
                                                <option value="{{$mitra->kodeMitra}}" selected>{{$mitra->nama}}</option>
                                                @else
                                                <option value="{{$mitra->kodeMitra}}">{{$mitra->nama}}</option>
                                                @endif
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
                                            <th width="15%">Material</th>
                                            <th width="20%">Keterangan</th>
                                            <th width="15%">Jumlah</th>
                                            <th width="5%">Satuan</th>
                                            <th width="20%">Harga</th>
                                            <th width="20%">Sub Total</th> 
                                            <th width="5%">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="{{$detailnota->count()}}"> 
                                        @php
                                        $itung=1;
                                        $grandtot=0;
                                        @endphp                  
                                        <tbody id='detail'>
                                        @foreach($detailnota as $detail)
                                        <tr id='no"+itung+"'>
                                        <td width='15%'>
                                            <select id='barang{{$itung}}' name='barang[]' onchange='setsatuan(this)' class='barang form-control'>"+"<option> -- Pilih Material -- </option>
                                                @foreach ($materials as $item)
                                                   @if($detail->kode_material===$item->kodeMaterial)
                                                   <option value='{{ $item->kodeMaterial }}' selected> ({{ $item->kodeMaterial }}) {{$item -> nama}}</option>
                                                   @else
                                                   <option value='{{ $item->kodeMaterial }}'> ({{ $item->kodeMaterial }}) {{$item -> nama}}</option>
                                                   @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width='25%' align='right' style='padding-right:10px;'><textarea class='form-control'  rows='2' style='resize:none;' name='keterangan[]' placeholder='Masukkan keterangan'>{{$detail->keterangan}}</textarea></td>
                                        <td width='15%'><input type='number' value="{{$detail->qty}}" name='qty[]' class='qty form-control' id='qty{{$itung}}' step='any' min='0' value='0' onkeyup='getTotal({{$itung}})' onchange='getTotal({{$itung}})' ></td>
                                        <td width='5%'><p id='satuan{{$itung}}'>{{$detail->material->satuan}}</p></td>
                                        <td width='20%'><input type='number' step='any' name='price[]' id='price{{$itung}}' class='form-control' value="{{$detail->harga}}" onkeyup='getTotal({{$itung}})' onchange='getTotal({{$itung}})'></td>
                                        <td width='20%'><input type='number' readonly name='total[]' value="{{$detail->harga*$detail->qty}}" id='total{{$itung}}' class='form-control'></td>
                                        <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='{{$itung}}' onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                        </tr>

                                        @php
                                        $grandtot+=$detail->harga*$detail->qty;
                                        $itung++;
                                        @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right" style="font-size: 1.3em; vertical-align: middle;">GRAND TOTAL</td>
                                                <td>
                                                    <b><input type="text" class='form-control' readonly value="{{$grandtot}}" name="grandTot" id="grandTot"></b>
                                                </td>
                                                <td></td>
                                            </tr>
                                             <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                            <tr>
                                                   <td colspan="2"><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                                                   <button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> UPDATE </button></td>
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


<script type="text/javascript"> 
 $(document).ready( function ()
{
    $('#tambah').click(function(e){
        e.preventDefault()
        var itung=$("#no").val();
        // var urut=$('#urut').val();
        
        itung++;
        var baris = "<tr id='no"+itung+"'>"+
                                                "<td width='15%'>"+
                                                    "<select id='barang"+itung+"' name='barang[]' onchange='setsatuan(this)' class='barang form-control'>"+"<option> -- Pilih Material -- </option>"+
                                                        @foreach ($materials as $item)
                                                           "<option value='{{ $item->kodeMaterial }}'> ({{ $item->kodeMaterial }}) {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td width='25%' align='right' style='padding-right:10px;'><textarea class='form-control'  rows='2' style='resize:none;' name='keterangan[]' placeholder='Masukkan keterangan'></textarea></td>"+
                                                "<td width='15%'><input type='number' name='qty[]' class='qty form-control' id='qty"+itung+"' step='any' min='0' value='0' onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")' ></td>"+
                                                "<td width='5%'><p id='satuan"+itung+"'></p></td>"+
                                                "<td width='20%'><input type='number' step='any' name='price[]' id='price"+itung+"' class='form-control' onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")'></td>"+
                                                "<td width='20%'><input type='number' readonly name='total[]' id='total"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });
    $('#norek').hide();

   
    
});

function setsatuan(param){
    var val=param.value;
    var temp=param.id;
    var itung=$("#no").val();
    var split=temp.split('barang');
    var id=split[1]

    var url="../getsatuan/"+val
    $.get(url, function(data){
        $('#satuan'+id).html(data)
    })
}

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function getTotal(no){
    var qty=$("#qty"+no).val();
    
    var harga=$('#price'+no).val();
    var total= qty*harga;
    $('#total'+no).val(total);
    getGrandTotal();
}

function getGrandTotal(){
    var arraytotal = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }
    document.getElementById('grandTot').value = tot;
}



    function getRekening()
    {
        if($('#pembayaran').val()=='transfer'){
             $('#norek').show();
        }
        else{
            $('#norek').hide();
        }
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