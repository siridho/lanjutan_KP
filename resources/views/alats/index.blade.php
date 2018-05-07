@extends('layouts.template')

@section('title','Master Data Alat')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Alat</div>
                    <div class="panel-body">
                         <a href="{{ url('/alats/create') }}" class="btn btn-success btn-sm" title="Tambah Alat Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <a href="{{ url('/alats/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor .xls
                        </a>
                        <a href="{{ url('printmaster','alat') }}" class="btn btn-primary btn-sm" title="Cetak PDF">
                            <i class="fa fa-print" aria-hidden="true"></i> Cetak PDF
                        </a>
                        <br>
                        <br>
                       <!--  <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/alats/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                            <div class="col-md-7">
                                    <input type='file' class='form-control pull-right;' name='filecsv'>
                                    {{csrf_field()}}
                            </div>
                            <div class="col-md-3">
                                    <button class='btn btn-primary pull-right;'>Import CSV</button>
                            </div>
                            </form>
                        </div> -->
                        <div class="">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 10%;">Kode Alat</th>
                                        <th style="text-align: center; width: 20%;">Nama</th>
                                        <th style="text-align: center; width: 10%;">Satuan</th>
                                        <th style="text-align: center; width: 20%;">Kelompok Utilitas</th>
                                        <th style="text-align: center; width: 20%;">Keterangan</th>
                                        <th style="text-align: center; width: 10%;">Masa Pakai</th>
                                        <th style="text-align: center; width: 10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($alats as $item)
                                    <tr>
                                        <td>{{ $item->kodeAlat }}</td>
                                        <td style="text-align: left;">{{ $item->nama }}</td>
                                        <td style="text-align: left;">{{ $item->Satuan }}</td>
                                        <td style="text-align: left;">{{ $item->getKelompokUtilitas($item->kodeAlat) }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->masapakai }}</td>
                                        <td>
                                          
                                            <a href="{{ url('/alats/' . $item->kodeAlat . '/edit') }}" title="Ubah Alat"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a><br>
                                           <!--  {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/alats', $item->kodeAlat],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete alat',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!} -->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
