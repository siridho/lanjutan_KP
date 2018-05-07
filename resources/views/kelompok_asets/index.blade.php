@extends('layouts.template')

@section('title','Daftar Kelompok Aset')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Kelompok Aset</div>
                    <div class="panel-body">
                        <a href="{{ url('/kelompok_asets/create') }}" class="btn btn-success btn-sm" title="Tambah Kelompok Aset Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Kode Kelompok Aset</th>
                                        <th>Nama</th>
                                        <th>Masapakai</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($kelompok_asets as $item)
                                    <tr>
                                        <td>{{ $item->kodeKelompokAset }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->masapakai }}</td>
                                        <td>
                                            <a href="{{ url('/kelompok_asets/' . $item->id) }}" title="View Kelompok_aset"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/kelompok_asets/' . $item->id . '/edit') }}" title="Ubah Kelompok Aset"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/kelompok_asets', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Kelompok_aset',
                                                        'onclick'=>'return confirm("Confirm delete?")'
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
    <!-- end of row -->

    </div>
</div>
@endsection