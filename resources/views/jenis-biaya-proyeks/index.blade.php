@extends('layouts.template')

@section('title','Master Data Jenis Biaya Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Jenis Biaya Proyek</div>
                    <div class="panel-body">
                        <a href="{{ url('/jenis-biaya-proyeks/create') }}" class="btn btn-success btn-sm" title="Tambah Jenis Biaya Proyek Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <a href="{{ url('/jenis-biaya-proyeks/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                         <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor .xls
                                    </a>
                        <a href="{{ url('printmaster','jenisbiayaproyek') }}" class="btn btn-primary btn-sm" title="Cetak PDF">
                            <i class="fa fa-print" aria-hidden="true"></i> Cetak PDF
                        </a>
                        <br>
                        <br>
                        <div class="">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Kode Jenis Biaya</th><th style="text-align: center;">Nama</th><th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jenisbiayaproyeks as $item)
                                    <tr>
                                        <td>{{ $item->kodeJenisBiaya }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                          
                                            <a href="{{ url('/jenis-biaya-proyeks/' . $item->kodeJenisBiaya . '/edit') }}" title="Ubah Jenis Biaya Proyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            <!-- {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/jenis-biaya-proyeks', $item->kodeJenisBiaya],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete JenisBiayaProyek',
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