@extends('layouts.template')

@section('title','Master Data Alat')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">alat {{ $alat->kodeAlat }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/alats') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/alats/' . $alat->kodeAlat . '/edit') }}" title="Edit alat"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['alats', $alat->kodeAlat],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete alat',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th> Kode Alat </th>
                                        <td> {{ $alat->kodeAlat }} </td>
                                    </tr>
                                    <tr>
                                        <th> Nama </th>
                                        <td> {{ $alat->nama }} </td>
                                    </tr>
                                    <tr>
                                        <th> Kelompok Utilitas </th>
                                        <td> {{ $alat->kelompokUtilitas }} </td>
                                    </tr>
                                    <tr>
                                        <th> Satuan </th>
                                        <td> {{ $alat->satuan }} </td>
                                    </tr>
                                     <tr>
                                        <th> Keterangan </th>
                                        <td> {{ $alat->keterangan }} </td>
                                    </tr>
                                     <tr>
                                        <th> Masa Pakai </th>
                                        <td> {{ $alat->masapakai }} </td>
                                    </tr>
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