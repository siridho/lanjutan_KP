@extends('layouts.template')

@section('title','Opname Volume Pekerjaan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div>
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Opname Volume Pekerjaan</div>
                    <div class="panel-body">
                        <a href="{{ url('/opname_volume_pekerjaans/create') }}" class="btn btn-success btn-sm" title="Tambah Opname Volume Pekerjaan Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <div class="row">
                            <form action="{{url('/opname-volume/exportcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                                {{csrf_field()}}
                                <div class="col-md-2">
                                    <input class="form-control date-picker birthday" type="text" required name="tglAwal">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date-picker birthday" type="text" required name="tglAkhir">
                                </div>
                                <div class="col-md-4">
                                    <button class='btn btn-primary pull-left'><i class="fa fa-file-excel-o"></i> Ekspor .xls</button>
                                </div>
                            </form>
                        </div>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Transaksi</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Kode Proyek</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($opname_volume_pekerjaans as $item)
                                    <tr>                                        
                                        <td>{{substr($item->nonota,6)}}</td>
                                        <td>{{ $item->tglNota }}</td>
                                        <td>{{ $item->kodeProyek }}</td>
                                        <td>
                                            <a href="{{ url('/opname_volume_pekerjaans/' . $item->nonota) }}" title="View Opname_volume_pekerjaan"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/opname_volume_pekerjaans/' . $item->nonota . '/edit') }}" title="Edit Opname_volume_pekerjaan"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/opname_volume_pekerjaans', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Opname_volume_pekerjaan',
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