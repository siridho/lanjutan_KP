@extends('layouts.template')

@section('title','Master Data Nota Beli Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Transaksi Beli Material No {{$notabelimaterial->nonota}}</div>
                    <div class="panel-body">
                    <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                    <a href="{{ url('printnota',['beli',$notabelimaterial->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Beli Material No {{$notabelimaterial->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-beli-material', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                @php
                                setlocale(LC_ALL, 'IND');
                                @endphp

                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;">No Transaksi Beli Material : </td>
                                        <td width="200px">{{$notabelimaterial->nonota}}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek : </td>
                                        <td width="200px">
                                           {{$notabelimaterial->proyek->uraian}}
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Transaksi : </td>
                                        <td width="200px">{{ strftime('%d %B %Y', strtotime($notabelimaterial->tglNota)) }}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Pembuat : </td>
                                        <td width="200px">
                                           {{$notabelimaterial->karyawan->nama}}
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Mitra Kerja : </td>
                                        <td width="200px">
                                           {{$notabelimaterial->mitra->nama}}
                                        </td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Status: </td>
                                        <td width="200px">
                                           {{$notabelimaterial->status}}
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="20%">Material</th>
                                            <th width="25%">Keterangan</th>
                                            <th width="10%">Jumlah</th>
                                            <th width="20%" style="text-align: right;">Harga</th>
                                            <th width="25%" style="text-align: right;">Sub Total</th>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                        <?php $grantot=0;?>
                                        @foreach($detailnota as $item)
                                        <tr >
                                                <td width='20%'>({{$item->material->kodeMaterial}}) {{$item->material->nama}}</td>
                                                <td width='25%'>{{$item->keterangan}}</td>
                                                <td width='10%'>{{$item->qty}} {{$item->material->satuan}}</td>
                                                <td width='20%' style="text-align: right;">Rp {{ number_format($item->harga,0,",",".") }}</td>
                                                <td width='25%' style="text-align: right;">Rp {{ number_format($item->qty*$item->harga,0,",",".") }}</td>
                                        </tr>
                                        <?php $grantot+=$item->qty*$item->harga; ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right"  style="font-size: 1.3em;">GRAND TOTAL</td>
                                                <td style="font-size: 1.3em; text-align: right;">
                                                <b>Rp <?php echo number_format($grantot,0,",","."); ?></b>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><a href="" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i>  CETAK</a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                           
                                        </tfoot>
                                    </table>
                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                            




                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection