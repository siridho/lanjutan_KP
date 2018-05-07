@extends('layouts.template')

@section('title','Master EDP User')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data EDP User</div>
                    <div class="panel-body">
                        <a href="{{ url('/users/create') }}" class="btn btn-success btn-sm" title="Tambah User Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                        <a href="{{ url('/users/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor .xls
                        </a>
                        <a href="{{ url('printmaster','user') }}" class="btn btn-primary btn-sm" title="Cetak PDF">
                            <i class="fa fa-print" aria-hidden="true"></i> Cetak PDF
                        </a>
                

                        <br>
                        <br>
                        <!-- <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                            <form action="{{url('/mitra-kerjas/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                            <table id="datatable" class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Nama</th>
                                         <th style="text-align: center;">Username</<th></th>
                                        <th style="text-align: center;">Email</th>
                                        <th style="text-align: center;">Level Jabatan</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                         <td>{{ $item->username }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->level }}</td>
                                        <td style="text-align: center;">
                                            <!-- <a href="{{ url('/mitra-kerjas/' . $item->kodeMitra) }}" title="View mitraKerja"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> -->
                                            <a href="{{ url('/users/' . $item->id . '/edit') }}" title="Ubah User"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                            <!-- {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/mitra-kerjas', $item->kodeMitra],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete mitraKerja',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!} -->
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