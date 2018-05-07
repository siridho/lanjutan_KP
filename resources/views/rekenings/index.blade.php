@extends('layouts.template')

@section('title','Daftar Rekening')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Rekening</div>
                    <div class="panel-body">
                        <a href="{{ url('/rekenings/create') }}" class="btn btn-success btn-sm" title="Tambah Rekening Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>

               

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nomor Rekening</th>
                                        <th>Nama Bank</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rekenings as $item)
                                    <tr>
                                        <td>{{ $item->kodeRekening }}</td>
                                        <td>{{ $item->norek }}</td>
                                        <td>{{ $item->namabank }}</td>
                                        <td>
                                            <a href="{{ url('/rekenings/' . $item->id) }}" title="View Rekening"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/rekenings/' . $item->id . '/edit') }}" title="Ubah Rekening"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/rekenings', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Rekening',
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