@extends('layouts.template')

@section('title','Master Data Gudang')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
        @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Gudang</div>
                    <div class="panel-body">
                        <a href="{{ url('/gudangs/create') }}" class="btn btn-success btn-sm" title="Tambah Gudang Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <a href="{{ url('/gudangs/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor .xls
                        </a>
                

                        <br>
                        <br>
                       <!--  <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/gudangs/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                            <div class="col-md-7">
                                    <input type='file' class='form-control pull-right;' name='filecsv'>
                                    {{csrf_field()}}
                            </div>
                            <div class="col-md-3">
                                    <button class='btn btn-primary pull-right;'>Import CSV</button>
                            </div>
                            </form>
                        </div> -->
                        <div class="">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                       <th style="text-align: center;">Kode Gudang</th><th style="text-align: center;">Nama</th><th style="text-align: center;">Keterangan</th><th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($gudangs as $item)
                                    <tr>
                                        <td>{{ $item->kodeGudang }}</td><td>{{ $item->nama }}</td><td>{{ $item->keterangan }}</td>
                                        <td>
                                            <a href="{{ url('/gudangs/' . $item->kodeGudang) }}" title="View gudang"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/gudangs/' . $item->kodeGudang . '/edit') }}" title="Ubah Gudang"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/gudangs', $item->kodeGudang],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete gudang',
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