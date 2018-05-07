@extends('layouts.template')

@section('title','Nota Kas Masuk')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Nota Kas Masuk</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-kas-masuk', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Penerimaan Kas </td>
                                        <td width="200px"><input placeholder="Masukkan nomor nota" class="form-control" type="text" required readonly name="nonota2" value="{{substr($kode,6)}}"></td>
                                        <input placeholder="Masukkan nomor nota" class="form-control" type="hidden" required readonly name="nonota" value="{{$kode}}">
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
                                        <td width="100px" align="right"  style="padding-right:10px;">Referensi</td>
                                        <td width="200px">
                                           <input class="form-control" type="text" name="cboreferensi" value="" placeholder="Masukkan Kode Referensi">
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                   
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="60%">Uraian</th>
                                            <th width="25%">Harga</th>
                                            <th width="15%">Aksi</th>                                         
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                        <tr id='no1'>
                                                <td width='60%'>
                                                    <textarea id='uraian1' name='uraian[]' class='uraian form-control' style='resize:none;'></textarea>
                                                </td>
                                                <td width='25%'><input type='number' step='any' required name='price[]' id='price1' class='form-control' onchange='getTotal(1)' onkeyup='getTotal(1)'></td>
                                                <td width='15%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='1'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>
                                            
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
                                               
                                                <td></td>
                                                <td></td>
                                                <td><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a><button class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> SIMPAN </button></td>
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
                                                    "<textarea id='uraian"+itung+"' required name='uraian[]' class='uraian form-control' style='resize:none;'></textarea>"+
                                                "</td>"+
                                                "<td width='25%'><input type='number' required step='any' name='price[]' id='price"+itung+"' class='form-control' onchange='getTotal("+itung+")' onkeyup='getTotal("+itung+")'></td>"+
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
