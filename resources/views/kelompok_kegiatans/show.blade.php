@extends('layouts.template')

@section('title','Master Data Kelompok Kegiatan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Kelompok Kegiatan {{ $kelompok_kegiatan->kodeKelompokKegiatan }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/kelompok_kegiatans') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/kelompok_kegiatans/' . $kelompok_kegiatan->kodeKelompokKegiatan . '/edit') }}" title="Edit Kelompok_kegiatan"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['kelompok_kegiatans', $kelompok_kegiatan->kodeKelompokKegiatan],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Hapus Kelompok Kegiatan',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th> Kode Kelompok Kegiatan </th>
                                        <td> {{ $kelompok_kegiatan->kodeKelompokKegiatan }} </td>
                                    </tr>
                                    <tr>
                                        <th> Nama </th>
                                        <td> {{ $kelompok_kegiatan->nama }} </td>
                                    </tr>
                                    <tr>
                                        <th> Satuan </th>
                                        <td> {{ $kelompok_kegiatan->satuan }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

</div>
@endsection
