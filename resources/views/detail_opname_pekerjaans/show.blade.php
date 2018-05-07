@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Detail_opname_pekerjaan {{ $detail_opname_pekerjaan->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/detail_opname_pekerjaans') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/detail_opname_pekerjaans/' . $detail_opname_pekerjaan->id . '/edit') }}" title="Edit Detail_opname_pekerjaan"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['detail_opname_pekerjaans', $detail_opname_pekerjaan->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Detail_opname_pekerjaan',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $detail_opname_pekerjaan->id }}</td>
                                    </tr>
                                    <tr><th> Nonota </th><td> {{ $detail_opname_pekerjaan->nonota }} </td></tr><tr><th> TglNota </th><td> {{ $detail_opname_pekerjaan->tglNota }} </td></tr><tr><th> NoBaris </th><td> {{ $detail_opname_pekerjaan->noBaris }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
