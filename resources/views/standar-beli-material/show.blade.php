@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">standarBeliMaterial {{ $standarbelimaterial->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/standar-beli-material') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/standar-beli-material/' . $standarbelimaterial->id . '/edit') }}" title="Edit standarBeliMaterial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['standarbelimaterial', $standarbelimaterial->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete standarBeliMaterial',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $standarbelimaterial->id }}</td>
                                    </tr>
                                    <tr><th> Kode Material </th><td> {{ $standarbelimaterial->kode_material }} </td></tr>
                                    <tr><th> Kode Mitra </th><td> {{ $standarbelimaterial->kode_mitra }} </td></tr>
                                    <tr><th> Harga Satuan </th><td>Rp {{ $standarbelimaterial->harga_satuan }} </td></tr>
                                    <tr><th> Jangka Bayar </th><td>Rp {{ $standarbelimaterial->janka_bayar}} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection