@extends('layouts.template')

@section('title','Kartu Stok Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Kartu Stok Material <br> Proyek IGD RSUD Sidoarjo
                    </div>
                    <div class="panel-body">
                    <a id="print" onclick="printpdf()" class="btn btn-primary btn-sm" title="CSV">
                            <i class="fa fa-print" aria-hidden="true"></i> Print
                    </a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/rekapitulasi-material', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p>Dicetak tanggal {{date('Y-m-d')}}</p>        
                                    </div>
                                    <div class="col-md-offset-5 col-md-2 text-center">
                                        Material: 
                                        <select class="form-control" name="cboMaterial" id="cboMaterial" onchange="tampilStok(this)">
                                            <option value="">-- Pilih Material --</option>
                                            @foreach($materials as $material)
                                            <option value="{{$material->kodeMaterial}}">{{$material->material->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="table table-responsive">
                                      <table id="datatable" class="table table-bordered text-center">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center;">Tanggal</th>
                                                <th style="vertical-align: middle; text-align: center;">Nomor</th>
                                                <th style="vertical-align: middle; text-align: center;">Uraian</th>
                                                <th style="vertical-align: middle; text-align: center;">Masuk</th>
                                                <th style="vertical-align: middle; text-align: center;">Keluar</th>
                                                <th style="vertical-align: middle; text-align: center;">Saldo</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id="detailStok">
                                           
                                        </tbody>
                                        <tfoot id="detailStokFoot">
                                            <tr>
                                                <td colspan="3">JUMLAH</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            {!! Form::close() !!}


<script type="text/javascript"> 

function tampilStok(param) {
    var idMaterial=param.value;
    if(idMaterial){
        var url="tampilStok/"+idMaterial
        $.get(url, function(data){
            $('#detailStok').html(data)
        })
        var url="tampilStokFoot/"+idMaterial
         $.get(url, function(data){
            $('#detailStokFoot').html(data)
        })
    }  
}

function printpdf(){
    var idMaterial=$('#cboMaterial').val();
    if(idMaterial){
        var url="kartustokpdf/"+idMaterial
        window.open(url)
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
