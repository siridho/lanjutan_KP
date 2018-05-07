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
                    <div class="panel-heading">Transaksi Penggunaan Material No {{$notapenggunaanmaterial->nonota}}</div>
                    <div class="panel-body">
                     <a href="{{ URL::previous() }}" class="btn btn-warning hidden-print" ><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                     <a href="{{ url('printnota',['guna',$notapenggunaanmaterial->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Penggunaan No {{$notapenggunaanmaterial->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-pengeluaran-kass', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Transaksi Penggunaan Material : </td>
                                        <td width="200px" id='nonota'>{{$notapenggunaanmaterial->nonota}}</td>
                                        <td width="100px" align="right" style="padding-right:10px; "> Proyek : </td>
                                        <td width="200px">{{$notapenggunaanmaterial->proyek->uraian}}</td>   
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Transaksi : </td>
                                        <td width="200px">{{$notapenggunaanmaterial->tanggalNota}}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Pembuat : </td>
                                        <td width="200px">{{$notapenggunaanmaterial->karyawan->name}}</td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Status : </td>
                                        <td width="200px">{{$notapenggunaanmaterial->status}}</td>
                                    </tr>
                                  
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="15%">Kode</th>
                                            <th width="30%">Keterangan</th>
                                            <th width="10%">Jumlah</th>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                        @foreach($detailnota as $item)
                                        <tr >
                                                <td width='25%'>({{$item->kodeMaterial}}) {{$item->material->nama}}</td>
                                                <td width="30%">{{$item->keterangan}}</td>
                                                <td width='15%'>{{$item->jumlah}} {{$item->material->satuan}}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    <script type="text/javascript">
        
    </script>
    </div>
</div>
@endsection