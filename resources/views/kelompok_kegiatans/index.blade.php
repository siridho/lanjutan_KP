@extends('layouts.template')

@section('title','Master Data Kelompok Kegiatan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
        <div>    
          @include('layouts.flash-message')
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Kelompok Kegiatan</div>
                    <div class="panel-body">
                        <a href="{{ url('/kelompok_kegiatans/create') }}" class="btn btn-success btn-sm" title="Tambah Kelompok Kegiatan Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <a href="{{ url('/kelompok_kegiatans/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Expor .xls
                        </a>
                        <a href="{{ url('printmaster','kelompok_kegiatan') }}" class="btn btn-primary btn-sm" title="Cetak PDF">
                            <i class="fa fa-print" aria-hidden="true"></i> Cetak PDF
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable-responsive" class="table table-bordered" data-toggle="table" data-show-print="true">
                                <thead>
                                    <tr>
                                        <th>Kode Kelompok Kegiatan</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($kelompok_kegiatans as $item)
                                    <tr>
                                        <td>{{ $item->kodeKelompokKegiatan }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>
                                            <a href="{{ url('/kelompok_kegiatans/' . $item->kodeKelompokKegiatan) }}" title="View Kelompok_kegiatan"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/kelompok_kegiatans/' . $item->kodeKelompokKegiatan . '/edit') }}" title="Ubah Kelompok Kegiatan"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/kelompok_kegiatans', $item->kodeKelompokKegiatan],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Hapus Kelompok Kegiatan',
                                                        'onclick'=>'return confirm("Apakah Anda yakin ingin menghapus data Kelompok Kegiatan ini?")'
                                                )) !!}
                                            {!! Form::close() !!}
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
        </div>
    <!-- end of row -->

</div>
@endsection

