@extends('layouts.template')

@section('title','Tambah Memo Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Memo Proyek</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/memo_proyeks', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <input type="hidden" name="status" value="menunggu">
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Memo Proyek </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota2" value="{{substr($kode,6)}}"></td>
                                        <input type="hidden" required readonly name="nonota" value="{{$kode}}">
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                            @foreach($proyeks as $proyek)
                                                {{$proyek->uraian}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Memo Proyek</td>
                                        <td width="200px"><input class="form-control date-picker birthday" type="text" required name="tglNota" ></td>
                                    </tr>
                          
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="">Uraian</th>
                                            <th width="">Nilai</th>
                                            <th width="">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                            <tr id='no1'>
                                                <td width='' style='padding-right:10px;'><textarea class='form-control'  rows='2' style='resize:none;' name='uraian[]' id='uraian1' placeholder='Masukkan uraian'></textarea></td>
                                                <td width=''><input type='number' step='any' name='nilai[]' id='price1' class='form-control' onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")' placeholder='Masukkan nilai'></td>
                                                <td width='' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                              
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


<script type="text/javascript"> 
 $(document).ready( function ()
{
    $('#tambah').click(function(e){
        e.preventDefault()
        var itung=$("#no").val();
        // var urut=$('#urut').val();
        
        itung++;
        var baris = "<tr id='no"+itung+"'>"+
                        "<td width='' style='padding-right:10px;'><textarea class='form-control' id='uraian"+itung+"' rows='2' style='resize:none;' name='uraian[]' placeholder='Masukkan uraian'></textarea></td>"+
                        "<td width=''><input type='number' step='any' name='nilai[]' id='price"+itung+"' class='form-control' onkeyup='getTotal("+itung+")' onchange='getTotal("+itung+")' placeholder='Masukkan nilai'></td>"+
                        "<td width='' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"+
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