@extends('layouts.app')

@section('content')
    <div>  @include('layouts.flash-message')
        <div class="row">
           <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Standar Beli Material</div>
                    <div class="panel-body">
                        <a href="{{ url('/standar-beli-material/create') }}" class="btn btn-success btn-sm" title="Add New standarBeliMaterial">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/standar-beli-material', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                            <form action="{{url('/standar-beli-material/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                                        <th>ID</th><th>Kode Material</th><th>Kode Mitra</th><th>Harga Satuan</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($standarbelimaterial as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->kode_material }}</td>
                                        <td>{{ $item->kode_mitra }}</td>
                                        <td>Rp {{ number_format($item->harga_satuan,0,",",".") }}</td>
                                        <td>
                                            <a href="{{ url('/standar-beli-material/' . $item->id) }}" title="View standarBeliMaterial"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/standar-beli-material/' . $item->id.'/edit') }}" title="Edit standarBeliMaterial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/standar-beli-material', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete standarBeliMaterial',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $standarbelimaterial->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                        <div class="row" style="margin-top: 2em; margin-bottom: 2em; margin-right: 2em;">
                            <div class="col-md-12" align="right">
                                    <a href="{{ url('/standar-beli-material/exportcsv') }}" class="btn btn-primary btn-sm" title="CSV">
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
