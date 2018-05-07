@extends('layouts.template')

@section('title','Detail Beli Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DetailBeliMaterial {{ $detailbelimaterial->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/detail-beli-materials') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/detail-beli-materials/' . $detailbelimaterial->id . '/edit') }}" title="Edit DetailBeliMaterial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['detailbelimaterials', $detailbelimaterial->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete DetailBeliMaterial',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $detailbelimaterial->id }}</td>
                                    </tr>
                                    <tr><th> Nonota </th><td> {{ $detailbelimaterial->nonota }} </td></tr><tr><th> Kode Material </th><td> {{ $detailbelimaterial->kode_material }} </td></tr><tr><th> Qty </th><td> {{ $detailbelimaterial->qty }} </td></tr>
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
