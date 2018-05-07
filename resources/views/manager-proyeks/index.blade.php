@extends('layouts.template')

@section('title','Master Data Manager Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Manager Proyek</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager-proyeks/create') }}" class="btn btn-success btn-sm" title="Add New managerProyek">
                            <i class="fa fa-plus" aria-hidden="true"></i> ATambah Baru
                        </a>
                        <a href="{{ url('/manager-proyeks/exportcsv') }}" class="btn btn-primary btn-sm" title="CSV">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor CSV
                        </a>
                        {!! Form::open(['method' => 'GET', 'url' => '/manager-proyeks', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                       <!--  <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/manager-proyeks/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                            <div class="col-md-7">
                                    <input type='file' class='form-control pull-right;' name='filecsv'>
                                    {{csrf_field()}}
                            </div>
                            <div class="col-md-3">
                                    <button class='btn btn-primary pull-right;'>Import CSV</button>
                            </div>
                            </form>
                        </div> -->
                       <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Kode Manager</th><th>Nama</th><th>Alamat</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($managerproyeks as $item)
                                    <tr>
                                        <td>{{ $item->kodeManager }}</td><td>{{ $item->nama }}</td><td>{{ $item->alamat }}</td>
                                        <td>
                                            <a href="{{ url('/manager-proyeks/' . $item->kodeManager) }}" title="View managerProyek"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/manager-proyeks/' . $item->kodeManager . '/edit') }}" title="Edit managerProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/manager-proyeks', $item->kodeManager],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete managerProyek',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $managerproyeks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection