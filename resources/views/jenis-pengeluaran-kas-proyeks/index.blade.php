@extends('layouts.template')

@section('title','Jenis Pengeluaran Kas Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Jenis Pengeluaran Kas Proyek</div>
                    <div class="panel-body">
                        <a href="{{ url('/jenis-pengeluaran-kas-proyeks/create') }}" class="btn btn-success btn-sm" title="Add New jenisPengeluaranKasProyek">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/jenis-pengeluaran-kas-proyeks', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br>
                        <br>
                        <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/jenis-pengeluaran-kas-proyeks/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                            <div class="col-md-7">
                                    <input type='file' class='form-control pull-right;' name='filecsv'>
                                    {{csrf_field()}}
                            </div>
                            <div class="col-md-3">
                                    <button class='btn btn-primary pull-right;'>Import CSV</button>
                            </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>kode Pengeluaran</th><th>Nama</th><th>Satuan</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jenispengeluarankasproyeks as $item)
                                    <tr>
                                        <td>{{ $item->kodePengeluaran }}</td><td>{{ $item->nama }}</td><td>{{ $item->satuan }}</td>
                                        <td>
                                            <a href="{{ url('/jenis-pengeluaran-kas-proyeks/' . $item->kodePengeluaran) }}" title="View jenisPengeluaranKasProyek"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/jenis-pengeluaran-kas-proyeks/' . $item->kodePengeluaran . '/edit') }}" title="Edit jenisPengeluaranKasProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/jenis-pengeluaran-kas-proyeks', $item->kodePengeluaran],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete jenisPengeluaranKasProyek',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $jenispengeluarankasproyeks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                        <div class="row" style="margin-top: 2em; margin-bottom: 2em; margin-right: 2em;">
                            <div class="col-md-12" align="right">
                                    <a href="{{ url('/jenis-pengeluaran-kas-proyeks/exportcsv') }}" class="btn btn-primary btn-sm" title="CSV">
                                        <i aria-hidden="true"></i> Export CSV
                                    </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection