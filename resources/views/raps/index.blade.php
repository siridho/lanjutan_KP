@extends('layouts.template')

@section('title','Data RAP')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Raps</div>
                    <div class="panel-body">
                        <a href="{{ url('/raps/create') }}" class="btn btn-success btn-sm" title="Tmbah RAP Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/raps', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        
                            <table style="width:100%" class="table table-bordered">
                                  @if($raps)
                                  @foreach($raps as $rap)
                                <thead>
                                    <tr >
                                      
                                        <td colspan="2" class="info"><b>RAP No. {{substr($rap->nonota, 6)}}</b></td>
                                        <td class="info">
                                            <a href="{{ url('/rap/' . $rap->nonota) }}" title="View Rap"><button class="btn btn-success btn-xs"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Pekerjaan</button></a>
                                            <a href="{{ url('/raps/' . $rap->nonota) }}" title="View Rap"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            {!! Form::open([
                                              'method'=>'DELETE',
                                                'url' => ['/raps', $rap->nonota],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Rap',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>

                                    </tr>
                                </thead>
                                    
                                <tbody>
                                    <tr>
                                        <th>Nama Pekerjaan</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                 @foreach($rap->detailpekerjaan($rap->nonota) as $pekerjaan)                                 
                                        <tbody id='detail'>

                                            <tr>
                                            
                                                <td id="pekerjaan{{$pekerjaan->kodeKelompokKegiatan}}">{{strtoupper($pekerjaan->Kelompok_kegiatan->nama)}}</td>
                                                <td>{{ucwords($pekerjaan->keterangan)}}</td>
                                                <td>  
                                                    <a href="{{ url('/editrap/' . $pekerjaan->nonota.'/'.$pekerjaan->kodeKelompokKegiatan) }}" title="Edit Rap"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                                    <a><button  class='btn btn-info btn-xs' data-toggle='modal' data-target='#mymodal' onclick='setModal("{{$rap->nonota}}", "{{$pekerjaan->kodeKelompokKegiatan}}",event)' data-title='Lihat Detail'><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                                    {!! Form::open([
                                                      'method'=>'POST',
                                                        'url' => ['/destroypekerjaan', $pekerjaan->nonota, $pekerjaan->Kelompok_kegiatan],
                                                        'style' => 'display:inline'
                                                    ]) !!}
                                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                                'type' => 'submit',
                                                                'class' => 'btn btn-danger btn-xs',
                                                                'title' => 'Delete Pekerjaan',
                                                                'onclick'=>'return confirm("Confirm delete?")'
                                                        )) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                @endforeach
                                </tbody>
                                  @endforeach
                                @endif
                            </table>
                          
                   

                    </div>
                </div>
            </div>
        </div>
     <!-- end of row -->

    </div>
</div>
@endsection


<div class="modal modal-md fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" width="100%">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="post" id="modalser">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Lihat Detail Pekerjaan </h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                         <thead align="center">
                            <th>Jenis Kegiatan</th>
                            <th>Minggu Mulai</th>
                            <th>Lama</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Total Kegiatan</th>                                      
                        </thead>
                        <input type="hidden" name="noBarisModal" id="noBarisModal" value="0"> 
                        <input type="hidden" name="noBiaya" id="noBiaya" value="0"> 
                        <tbody id='detailBiaya'>
                            
                        </tbody>  
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right" style="font-size: 1.3em; font-weight: bold; vertical-align: middle;">SUBTOTAL BIAYA</td>
                                <td colspan="2"  style="font-size: 1.3em; font-weight: bold; vertical-align: middle; text-align: right;"  id="grandTotBiaya" ></td>
                                
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

function setModal(nonota, pekerjaan, e){
    e.preventDefault()
    $('#detailBiaya').html('')
    $('#noBarisModal').val(nonota)  

    var val = nonota
    

    var url = "getmodalpekerjaan/"+val+"/"+pekerjaan
    $.get(url, function(data){

         var obj = JSON.parse(data)
          // alert(obj[0])
          var grand=0;

        for(var i=0; i<obj.length; i++){
            
            var baris = "<tr>"+
                        "<td width='30%'>"+
                            obj[i].kodeKelompokKegiatan+'-'+obj[i].nama+
                        "</td>"+
                        "<td width='8%' align='right' style='padding-right:10px;'>"+obj[i].minggu_mulai+" Mg</td>"+
                        "<td width='8%'>"+obj[i].lama+" Mg</td>"+
                        "<td width='' style='text-align: center;'>"+obj[i].volume+"</td>"+
                        "<td width='3%'>"+obj[i].satuan+"</td>"+
                        "<td width='' style='text-align: right;'>Rp "+obj[i].hargaSat.toLocaleString('en')+"</td>"+
                        "<td width='' style='text-align: right;' >Rp "+obj[i].totalHarga.toLocaleString('en')+"</td>"+
                    "</tr>";
                    
                    $('#detailBiaya').append(baris)
            
            grand+=obj[i].totalHarga;
                    
        }

        $('#grandTotBiaya').html('Rp '+grand.toLocaleString('en'))        
        $('#myModalLabel').html($('#pekerjaan'+pekerjaan).html())        
    })

}

</script>