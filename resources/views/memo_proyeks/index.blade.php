@extends('layouts.template')

@section('title','Memo Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Memo Proyek</div>
                    <div class="panel-body">
                        <a href="{{ url('/memo_proyeks/create') }}" class="btn btn-success btn-sm" title="Tambah Memo Proyek Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <div class="row">
                            <form action="{{url('/memo_proyeks/exportcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No. Memo Proyek</th>
                                        <th style="text-align: center;">Tanggal Transaksi</th>
                                        <th style="text-align: center;">Pembuat</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($memo_proyeks as $item)
                                    <tr>
                                        <td>{{ $item->nonota }}</td>
                                        <td>{{ $item->tgl }}</td>
                                        <td>{{ $item->id_karyawan->nama }}</td>
                                        <td>
                                            <a href="{{ url('/memo_proyeks/' . $item->nonota) }}" title="View Memo_proyek"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/memo_proyeks/' . $item->nonota . '/edit') }}" title="Edit Memo_proyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/memo_proyeks', $item->nonota],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Memo_proyek',
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