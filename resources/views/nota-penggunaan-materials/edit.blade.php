@extends('layouts.template')

@section('title','Nota Penggunaan Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Nota Penggunaan Material</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => ['/nota-penggunaan-materials', $notapenggunaanmaterial->nonota], 'method' => 'PATCH', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Nota </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required name="nonota" readonly value="{{substr($notapenggunaanmaterial->nonota,6)}}"></td>
                                        <td width="100px" align="right" style="padding-right:10px;"> Proyek </td>
                                        <td width="200px">
                                                @foreach($proyeks as $proyek)
                                                    {{$proyek->uraian}}
                                                @endforeach
                                        </td>
                                    </tr>

                                     @php
                                    $tgl=date_create($notapenggunaanmaterial->tanggalNota);
                                    $tgl=date_format($tgl,'m/d/Y');
                                    @endphp
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota </td>
                                        <td width="200px"><input class="form-control date-picker birthday" value="{{$tgl}}" type="text" required name="tglNota" ></td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Referensi</td>
                                        <td width="200px">
                                            <input placeholder="Masukkan nomor referensi" value="{{$notapenggunaanmaterial->referensi}}" class="form-control" name="cboreferensi">
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        
                                        <td width="100px" align="right" style="padding-right:10px;"></td>
                                        <td width="200px">
                                        </td>
                                    </tr>
                                   
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead >
                                            <th width="30%">Material</th>
                                            <th width="20%">Jumlah</th>
                                            <th width="5%">Satuan</th>
                                            <th width="40">Keterangan</th>
                                            <th width="5%">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="{{$detailnota->count()}}">
                                        <input type="hidden" name="jumbar" id="jumbar" value="0">  
                                        <input type="hidden" name="arr" id="arr" value="">                                     
                                        <tbody id='detail'>
                                        @php
                                        $itung=1;
                                        $grandtot=0;
                                        @endphp                  
                                        <tbody id='detail'>
                                        @foreach($detailnota as $detail)
                                        <tr id='no{{$itung}}'>
                                        <td width='15%'>
                                            <select id='barang{{$itung}}' name='barang[]' onchange='setsatuan(this)' class='barang form-control'>"+"<option> -- Pilih Material -- </option>
                                                @foreach ($materialproyeks as $item)
                                                   @if($detail->kodeMaterial===$item->kodeMaterial)
                                                   <option value='{{ $item->kodeMaterial }}' selected> ({{ $item->kodeMaterial }}) {{$item ->material-> nama}}</option>
                                                   @else
                                                   <option value='{{ $item->kodeMaterial }}'> ({{ $item->kodeMaterial }}) {{$item ->material-> nama}}</option>
                                                   @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td width='10%'><input type='number' step='any' name='qty[]' class='qty form-control' id='qty{{$itung}}' min='0' value='{{$detail->jumlah}}' onchange='getTotal({{$itung}})' ></td><td width="5%">{{$detail->material->satuan}}</td>
                                                <td width='35%'><textarea name='keterangan[]' rows='2' style='resize:none;' class='keterangan form-control' id='keterangan{{$itung}}'>{{$detail->keterangan}}</textarea></td>
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
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                            <tr>
                                           
                                                <td><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN </button></td>
                                                <td></td>
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

    var arrbar=[];
    $('#arr').val(arrbar)
    $('#tambah').click(function(e){
        e.preventDefault()
        var itung=$("#no").val();
        // var urut=$('#urut').val();
        var jumbar=$('#jumbar').val();
        var maxbar=$('#maxbar').val();
        itung++;
        jumbar++;
        var baris = "<tr id='no"+itung+"'>"+
                                                "<td width='30%'>"+
                                                    "<select id='barang"+itung+"' name='barang[]' onchange='setjumlah(this)' class='barang form-control'>"+"<option> -- Pilih Material -- </option>"+
                                                        @foreach ($materialproyeks as $item)
                                                           "<option value='{{ $item->kodeMaterial }}'> ({{ $item->kodeMaterial }}) {{$item->material->nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td width='20%'><input type='number' step='any' name='qty[]' class='qty form-control' id='qty"+itung+"' min='1' value='0' onkeyup='setmax("+itung+")' onchange='setmax("+itung+")' ></td>"+
                                                "<td width='5%'><p id='satuan"+itung+"'></p></td>"+
                                                 "<td width='45%'>"+
                                                    "<textarea id='keterangan"+itung+"' name='keterangan[]' class='keterangan form-control' style='resize:none;'></textarea>"+
                                                "</td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
        $('#jumbar').val(jumbar);

        // if(jumbar==maxbar){
        //     $('#tambah').hide();
        // }
    });
    $('#norek').hide();
    
});

function setjumlah(param){
    var temp=param.id;
    var valu=param.value
    var itung=$("#no").val();
    var split=temp.split('barang');
    var id=split[1]    
    // var arrbar=$('#arr').val()
    
    // // if(arrbar){
    // //     if(arrbar[id-1]==valu)
    // // }
        var val=param.value;
        
    //         var url="../setjumlah/"+val
    //         $.get(url, function(data){
    //             $('#qty'+id).attr({
    //                "max" : data,
    //                "min" : 0
    //             });
    //         })

    url="../getsatuan/"+val
    $.get(url, function(data){
        $('#satuan'+id).html(data)
    })
        
       
 }

 function setmax(param){
    // var index=param-1;
    // var arrbar=$('#arr').val()
    // arrbar=arrbar.split(',')
    
    //  var duplicates = '';
    // for (var i = 0; i < arrbar.length; i++) {
    //     // if(duplicates.hasOwnProperty(arrbar[i])) {
    //     //     duplicates[arrbar[i]].push(i);
    //     // } else if (arrbar.lastIndexOf(arrbar[i]) !== i) {
    //     //     duplicates[arrbar[i]] = [i];
    //     // }
    //     if(index!=i){
    //         // if(duplicates=='')
    //         // duplicates=i;
    //         // else
    //         // duplicates+=','+i
    //         duplicates+=i
    //     }
    // }
    // // console.log(duplicates)

    // duplicates=duplicates.split('')
    // var val=$('#barang'+param).val()
    // var url="../setjumlah/"+val
    //         $.get(url, function(data){
    //             // $('#qty'+param).attr({
    //             //    "max" : data,
    //             //    "min" : 1
    //             // });
    //             var max=data

    //              for (var i = 0; i < duplicates.length; i++) {
                    
    //                 var ii=parseInt(duplicates[i])+1;
    //                 console.log(ii)
    //                 if($('#qty'+ii).val()){
    //                     max=max-$('#qty'+ii).val()
    //                 }

    //             }

    //             $('#qty'+param).attr({
    //                "max" : max,
    //                "min" : 0
    //             });


    //         })






 }



function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
     var jumbar=$('#jumbar').val();
     // var val=$('#barang'+param.id).val()
     // var max=$('#qty'+param.id).attr('max')
     // var arrbar=$('#arr').val()
     // arrbar=arrbar.split(',')
     // for (var i = 0; i < arrbar.length; i++) {
     //    if(arrbar[i]==val){
     //        var ind=i+1;
     //         max+=$('#qty'+ind).attr('max')
     //        $('#qty'+ind).attr({
     //               "max" : max,
     //               "min" : 0
     //            });
     //        break
     //    }
     // }
     // jumbar--;
     // $('#jumbar').val(jumbar);
     // $('#tambah').show();
    // return false;
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