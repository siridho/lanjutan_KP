@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
              @include('layouts.flash-message')
       <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Mata Anggaran Proyek</div>
                    <div class="panel-body">
                        <a href="{{ url('/mata-anggaran-proyeks/create') }}" class="btn btn-success btn-sm" title="Add New mataAnggaranProyek">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/mata-anggaran-proyeks', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                            <form action="{{url('/mata-anggaran-proyeks/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                                        <th>Kode Kelompok Anggaran</th><th>Nama</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($mataanggaranproyeks as $item)
                                    <tr>
                                        <td>{{ $item->kodeKelompokAnggaran }}</td><td>{{ $item->nama }}</td>
                                        <td>
                                            <a href="{{ url('/mata-anggaran-proyeks/' . $item->kodeKelompokAnggaran) }}" title="View mataAnggaranProyek"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/mata-anggaran-proyeks/' . $item->kodeKelompokAnggaran . '/edit') }}" title="Edit mataAnggaranProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/mata-anggaran-proyeks', $item->kodeKelompokAnggaran],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete mataAnggaranProyek',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $mataanggaranproyeks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                        <div class="row" style="margin-top: 2em; margin-bottom: 2em; margin-right: 2em;">
                            <div class="col-md-12" align="right">
                                    <a href="{{ url('/mata-anggaran-proyeks/exportcsv') }}" class="btn btn-primary btn-sm" title="CSV">
                                        <i aria-hidden="true"></i> Export CSV
                                    </a>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
