@extends('layouts.template')

@section('title','Master Data Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div>  
        @include('layouts.flash-message')
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Data Material</div>
                        <div class="panel-body">
                            <a href="{{ url('/materials/create') }}" class="btn btn-success btn-sm" title="Tambah Material Baru">
                                <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                            </a>
                            <a href="{{ url('/materials/exportcsv') }}" class="btn btn-primary btn-sm" title="Ekspor .xls">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ekspor .xls
                            </a>
                            <a href="{{ url('printmaster','material') }}" class="btn btn-primary btn-sm" title="Cetak PDF">
                                <i class="fa fa-print" aria-hidden="true"></i> Cetak PDF
                            </a>
               

                            <br>
                            <br>
                           <!--  <div class="row" style="margin-top: 3em; margin-bottom: 1em;">
                                <form action="{{url('/materials/importcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                                <table id="datatable-responsive" class="table table-bordered" data-toggle="table" data-show-print="true">
                                    <thead >
                                        <tr>
                                            <th style="text-align: center;" data-field="kode">Kode Material</th>
                                            <th style="text-align: center;" data-field="nama">Nama</th>
                                            <th style="text-align: center;" data-field="satuan">Satuan</th>
                                            <th style="text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($materials as $item)
                                        <tr>
                                            <td>{{ $item->kodeMaterial }}</td><td>{{ $item->nama }}</td><td>{{ $item->satuan }}</td>
                                            <td style="text-align: center;">
                                               
                                                <a href="{{ url('/materials/' . $item->kodeMaterial . '/edit') }}" title="Ubah Material"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ubah</button></a>
                                             <!--    {!! Form::open([
                                                    'method'=>'DELETE',
                                                    'url' => ['/materials', $item->kodeMaterial],
                                                    'style' => 'display:inline'
                                                ]) !!}
                                                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                            'type' => 'submit',
                                                            'class' => 'btn btn-danger btn-xs',
                                                            'title' => 'Delete material',
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
    </div>
        <!-- end of row -->

</div>
@endsection

