@extends('layouts.template')

@section('title','Tambah Opname Volume Pekerjaan')


@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div class="x_content">

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Opname Volume Pekerjaan</div>
                    <div class="panel-body">
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @php
                        $tgl=date('m/d/Y',strtotime($notaopname->tglNota));
                        $itung=1;
                        setlocale(LC_ALL, 'IND');
                        @endphp
                         {!! Form::open(['url' => ['/opname_volume_pekerjaans',$notaopname->nonota], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                                <table width="100%">
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px;"> No Opname Volume Pekerjaan </td>
                                        <td width="200px"> {{substr($notaopname->nonota,6)}}</td>
                                        <input placeholder="Masukkan nomor nota" class="form-control" type="hidden" required readonly name="nonota" value="{{$notaopname->nonota}}">
                                        <td width="100px" align="right"  style="padding-right:10px;">Proyek</td>
                                        <td width="200px">
                                            @foreach($proyeks as $proyek)
                                                {{$proyek->uraian}}
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr height="50px">
                                        <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota </td>
                                        <td width="200px">{{strftime('%d %B %Y', strtotime($tgl))}}</td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                   
                                </table>
                                <br>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <!-- <th>No</th> -->
                                            <th width="60%">Kode Kelompok Kegiatan</th>
                                            <th width="25%">Volume Minggu Ini</th>
                                            <th width="25%">Satuan</th>                                        
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="{{$details->count()}}">                                   
                                        <tbody id='detail'>
                                        @foreach($details as $item)
                                        <tr>
                                                <td width='15%'>
                                                    <!-- <input id='kode1' name='kode[]' class='kode form-control'> -->
                                                   {{$item->kelompokkegiatan->nama}} ({{$item->kodeKelompokKegiatan}})</option>
                                                </td>
                                                <td width='25%'>{{$item->volume}}</td>
                                                <td width='5%'>{{$item->kelompokkegiatan->satuan}}</td>
                                            
                                                </tr>
                                                @php
                                                $itung++;
                                                @endphp
                                            @endforeach
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
                                               
                                                
                                                <td><a href="{{ URL::previous() }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> KEMBALI</a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              <input type="hidden" name="id_karyawan" value="1">
                            {!! Form::close() !!}



                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
