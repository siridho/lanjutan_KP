@extends('layouts.app')

@section('content')
    <div class="container">
        <div>  @include('layouts.flash-message')
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Standar Sewa Alat</div>
                    <div class="panel-body">
                        <a href="{{ url('/standar-sewa-alat/create') }}" class="btn btn-success btn-sm" title="Add New standarSewaAlat">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/standar-sewa-alat', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>

                        <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/standar-sewa-alat/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                                        <th>ID</th><th>Kode Alat</th><th>Kode Mitra</th><th>Harga Satuan</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($standarsewaalat as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->kode_alat }}</td>
                                        <td>{{ $item->kode_mitra }}</td>
                                        <td>Rp {{ number_format($item->harga_satuan,0,",",".") }}</td>
                                        <td>
                                            <a href="{{ url('/standar-sewa-alat/' . $item->id) }}" title="View standarSewaAlat"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/standar-sewa-alat/' . $item->id . '/edit') }}" title="Edit standarSewaAlat"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/standar-sewa-alat', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete standarSewaAlat',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $standarsewaalat->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                        <div class="row" style="margin-top: 2em; margin-bottom: 2em; margin-right: 2em;">
                            <div class="col-md-12" align="right">
                                    <a href="{{ url('/standar-sewa-alat/exportcsv') }}" class="btn btn-primary btn-sm" title="CSV">
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
