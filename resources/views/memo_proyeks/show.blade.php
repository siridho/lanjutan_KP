@extends('layouts.template')

@section('title','Detail Memo Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Transaksi Memo Proyek No {{$memo_proyek->nonota}}</div>
                    <div class="panel-body">
                    <a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> BATAL</a>
                    <a href="{{ url('printnota',['memoProyek',$memo_proyek->nonota]) }}" class="btn btn-success btn-sm" title="Print Transaksi Penerimaan Kas No {{$memo_proyek->nonota}}"><i class="fa fa-print" aria-hidden="true"></i> CETAK</a>
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
                                        <td width="200px" align="right" style="padding-right:10px;">No. Memo Proyek : </td>
                                        <td width="200px">{{ substr($memo_proyek->nonota, 6) }}</td>
                                        <td width="200px" align="right" style="padding-right:10px; "> Proyek : </td>
                                        <td width="200px">{{$memo_proyek->proyek->uraian}}</td>
                                    </tr>
                                    <tr height="50px">
                                        
                                        <td width="200px" align="right"  style="padding-right:10px;">Pembuat :</td>
                                        <td width="200px">
                                           {{$memo_proyek->karyawan->nama}}
                                        </td>
                                        <td width="200px" align="right" style="padding-right:10px; "> Tanggal Transaksi: </td>
                                        <td width="200px">{{$memo_proyek->tgl}}</td>
                                        </td>
                                    </tr>
                                     <tr>
                                        
                                    </tr>
                                  
                                </table>
                                <br>
                                <div class="table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="70%" style="text-align: center;">Uraian</th>
                                            <th width="30%" style="text-align: center;">Nilai</th>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="1">                                   
                                        <tbody id='detail'>
                                        
                                        @foreach($detailnota as $item)
                                        <tr >
                                                <td width='70%'>{{$item->uraian}}</td>
                                                <td width='30%' style="text-align: right;">Rp {{ number_format($item->nilai,0,",",".") }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                      
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