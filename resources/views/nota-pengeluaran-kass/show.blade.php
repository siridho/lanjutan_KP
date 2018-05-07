@extends('layouts.template')

@section('title','Detail Transaksi Pengeluaran Kas')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Transaksi Pengeluaran Kas No {{$notapengeluarankass->nonota}}</div>
                    <div class="panel-body">
                    <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                    <a href="{{ url('printnota',['keluarkas',$notapengeluarankass->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Pengeluaran Kas No {{$notapengeluarankass->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
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

                                @php
                                setlocale(LC_ALL, 'IND');
                                @endphp
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="200px" align="right" style="padding-right:10px;"> No Transaksi Pengeluaran Kas : </td>
                                        <td width="200px">{{ substr($notapengeluarankass->nonota,6) }}</td>
                                        <td width="100px" align="right" style="padding-right:10px; "> Proyek : </td>
                                        <td width="200px">{{ $notapengeluarankass->proyek->uraian }}</td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Transaksi : </td>
                                        <td width="200px">{{ strftime('%d %B %Y', strtotime($notapengeluarankass->tglNota)) }}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Status : </td>
                                        <td width="200px">
                                           {{ $notapengeluarankass->status_nota }}
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Pembuat : </td>
                                        <td width="200px">
                                           {{ $notapengeluarankass->karyawan->nama }}
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="25%" style="text-align: center;">Uraian</th>
                                            <th width="15%" style="text-align: center;">Kode</th>
                                            <th width="10%" style="text-align: center;">Jumlah</th>
                                            <th width="20%" style="text-align: center;">Harga</th>
                                            <th width="30%" style="text-align: center;">Sub Total</th>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                        <?php $grantot=0;?>
                                        @foreach($detailnota as $item)
                                        <tr >
                                                <td width='25%'>{{$item->uraian}}</td>
                                                <td width='15%' style="text-align: center;">{{$item->kodeBiayaKas?$item->kodeBiayaKas:$item->kodeAlat}}</td>
                                                <td width='10%' style="text-align: center;">{{$item->jumlah}}</td>
                                                <td width='20%' style="text-align: right;">Rp {{ number_format($item->harga,0,",",".")}}</td>
                                                <td width='30%' style="text-align: right;">Rp {{ number_format($item->jumlah*$item->harga,0,",",".")}}</td>
                                        </tr>
                                        <?php $grantot+=$item->jumlah*$item->harga; ?>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="border-top: gray 2px solid">
                                                <td align="right" colspan="4" style="font-size: 1.3em; text-align: right;"><b>GRAND TOTAL</b></td>
                                                <td  style="font-size: 1.3em; text-align: right;">
                                                <b>Rp <?php echo number_format($grantot,0,",","."); ?></b>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <a href="" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i>  CETAK</a>
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