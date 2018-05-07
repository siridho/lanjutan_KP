@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">standarSewaAlat {{ $standarsewaalat->id }}</div>
                    <div class="panel-body">

                        <a href="{{ URL::previous() }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/standar-sewa-alat/' . $standarsewaalat->id . '/edit') }}" title="Edit standarSewaAlat"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['standarsewaalat', $standarsewaalat->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete standarSewaAlat',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $standarsewaalat->id }}</td>
                                    </tr>
                                    <tr><th> Kode Alat </th><td> {{ $standarsewaalat->kode_alat }} </td></tr>
                                    <tr><th> Kode Mitra </th><td> {{ $standarsewaalat->kode_mitra }} </td></tr>
                                    <tr><th> Harga Satuan </th><td>Rp {{ $standarsewaalat->harga_satuan }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
