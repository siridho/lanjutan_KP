@extends('layouts.template')

@section('title','Master Data Kategori')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div>

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Transaksi Penerimaan Material</div>
                    <div class="panel-body">
                     <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                     <a href="{{ url('printnota',['terima',$notaterimabarang->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Penerimaan Material No {{$notaterimabarang->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;">No Transaksi Penerimaan Material : </td>
                                        <td width="200px">{{$notaterimabarang->nonota}}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek : </td>
                                        <td width="200px">
                                        {{$notaterimabarang->proyek->uraian}}
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; ">Tanggal Transaksi : </td>
                                        <td width="200px">{{$notaterimabarang->tglNota}}</td>
                                        <td width="100px" align="right"  style="padding-right:10px;">Referensi : </td>
                                        <td width="200px">
                                            {{$notaterimabarang->nonota_beli}}
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right"  style="padding-right:10px;">Mitra : </td>
                                        <td width="200px">
                                            {{$notaterimabarang->mitra->nama}}
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="30%">Material</th>
                                            <th width="30%">Keterangan</th>
                                            <th width="10%">Jumlah</th>
                                                                              
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                            @foreach($detailnota as $item)
                                            <tr>
                                                <td width='30%'>
                                                  {{$item->material->kodeMaterial}} - {{$item->material->nama}}
                                                </td>
                                                <td width="30%">{{$item->keterangan}}</td>
                                                <td width='10%'> {{$item->jumlah}} {{$item->material->satuan}}</td>
                                                   
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

    </div>
</div>
@endsection