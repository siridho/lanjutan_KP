@extends('layouts.template')

@section('title','RAP')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">RAP No {{$rap->nonota}}</div>
                    <div class="panel-body">
                    <a href="{{ url('raps') }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                    <a href="{{ url('printrap',[$rap->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Beli Material No {{$rap->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/rap', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}

                                @php
                                setlocale(LC_ALL, 'IND');
                                @endphp

                                <table width="100%">
                                    <tr height="30px">
                                        <td width="100px" align="right" style="padding-right:10px;">No RAP : </td>
                                        <td width="200px">{{$rap->nonota}}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek : </td>
                                        <td width="200px">{{$rap->proyek->uraian}}
                                        </td>
                                    </tr>
                                    <tr height="30px">
                                        <td width="100px" align="right" style="padding-right:10px;">Tgl RAP : </td>
                                        <td width="200px">{{strftime('%d %B %Y', strtotime($rap->tglNota))}}</td>
                                        </td>
                                        <td width="100px" align="right" style="padding-right:10px;">Pembuat : </td>
                                        <td width="200px">{{$rap->karyawan->nama}}</td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                    
                                      <table class="table">
                                        
                                        <input type="hidden" name="no" id="no" value="1">  

                                        @php $grandtot=0;  @endphp
                                        @foreach($rap->detailpekerjaan($rap->nonota) as $pekerjaan)

                                        <tbody id='detail'>
                                            <tr>
                                                <td colspan='1' class="info"><b>{{strtoupper($pekerjaan->Kelompok_kegiatan->nama)}}</b></td>
                                                <td colspan='7' class="info">{{$pekerjaan->keterangan}}</td>
                                            </tr>

                                            <tr>
                                                <th >Kode</th>
                                                <th >Pekerjaan</th>
                                                <th >Minggu Mulai</th>
                                                <th >Lama</th>
                                                <th >Volume</th>
                                                <th >Satuan</th>
                                                <th  style="text-align: left;">Harga Satuan</th>
                                                <th  style="text-align: left;">Total Kegiatan</th>
                                            </tr>     
                                            @foreach($pekerjaan->detailkegiatan as $kegiatan)
                                                <tr>
                                                    <td>{{$kegiatan->Kelompok_kegiatan->kodeKelompokKegiatan}}</td>
                                                    <td>{{$kegiatan->Kelompok_kegiatan->nama}}</td>
                                                    <td>{{$kegiatan->minggu_mulai}}</td>
                                                    <td>{{$kegiatan->lama}}</td>
                                                    <td>{{$kegiatan->volume}}</td>
                                                    <td>{{$kegiatan->Kelompok_kegiatan->satuan}}</td>
                                                    <td align="right">Rp {{number_format($kegiatan->hargaSat,0,",",".")}}</td>
                                                    <td align="right">Rp {{number_format($kegiatan->totalHarga,0,",",".")}}</td>
                                                </tr>
                                            
                                            @endforeach

                                        <tr>
                                            <td colspan="7" align="right"><b>TOTAL</b></td>
                                            <td align="right"><b>Rp {{ number_format($kegiatan->subtotalkegiatan($rap->nonota, $kegiatan->kode_pekerjaan),0,",",".") }}</b></td>
                                        </tr>

                                        </tbody>

                                        @php $grandtot+=$kegiatan->subtotalkegiatan($rap->nonota, $kegiatan->kode_pekerjaan); @endphp
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td align="right"  style="font-size: 1.3em;" colspan="7">GRANDTOTAL</td>
                                                <td style="font-size: 1.3em; text-align: right;">
                                                <b>Rp {{number_format($grandtot, 0,",",".")}}</b>
                                                </td>
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