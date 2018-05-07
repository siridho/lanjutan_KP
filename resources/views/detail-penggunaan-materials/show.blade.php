@extends('layouts.template')

@section('title','Detail Penggunaan Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DetailPenggunaanMaterial {{ $detailpenggunaanmaterial->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/detail-penggunaan-materials') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/detail-penggunaan-materials/' . $detailpenggunaanmaterial->id . '/edit') }}" title="Edit DetailPenggunaanMaterial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['detailpenggunaanmaterials', $detailpenggunaanmaterial->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete DetailPenggunaanMaterial',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $detailpenggunaanmaterial->id }}</td>
                                    </tr>
                                    <tr><th> Nonota </th><td> {{ $detailpenggunaanmaterial->nonota }} </td></tr><tr><th> KodeMaterial </th><td> {{ $detailpenggunaanmaterial->kodeMaterial }} </td></tr><tr><th> Jumlah </th><td> {{ $detailpenggunaanmaterial->jumlah }} </td></tr>
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