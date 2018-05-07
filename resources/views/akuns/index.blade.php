@extends('layouts.template')

@section('title','Daftar Akun')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div>
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Akun</div>
                    <div class="panel-body">
                        <a href="{{ url('/akuns/create') }}" class="btn btn-success btn-sm" title="Tambah Akun Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($akuns as $item)
                                    <tr>
                                        <td>{{ $item->noAkun }}</td>
                                        <td>{{ $item->namaakun }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ url('/akuns/' . $item->id) }}" title="View Akun"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/akuns/' . $item->id . '/edit') }}" title="Ubah Akun"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/akuns', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Akun',
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