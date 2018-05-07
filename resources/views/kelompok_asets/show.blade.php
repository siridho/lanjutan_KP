@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Kelompok_aset {{ $kelompok_aset->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/kelompok_asets') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/kelompok_asets/' . $kelompok_aset->id . '/edit') }}" title="Edit Kelompok_aset"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['kelompok_asets', $kelompok_aset->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Kelompok_aset',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $kelompok_aset->id }}</td>
                                    </tr>
                                    <tr><th> KodeKelompokAset </th><td> {{ $kelompok_aset->kodeKelompokAset }} </td></tr><tr><th> Nama </th><td> {{ $kelompok_aset->nama }} </td></tr><tr><th> Masapakai </th><td> {{ $kelompok_aset->masapakai }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
