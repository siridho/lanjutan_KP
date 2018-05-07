@extends('layouts.template')

@section('title','Master Data Jenis Biaya Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Jenis Biaya Proyek #{{ $jenisbiayaproyek->kodeJenisBiaya }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/jenis-biaya-proyeks') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/jenis-biaya-proyeks/' . $jenisbiayaproyek->kodeJenisBiaya . '/edit') }}" title="Edit JenisBiayaProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['jenisbiayaproyeks', $jenisbiayaproyek->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete JenisBiayaProyek',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive col-md-offset-2 col-md-6">

                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="text-align: right"> Kode Jenis Biaya: </th>
                                        <td> {{ $jenisbiayaproyek->kodeJenisBiaya }} </td>
                                    </tr>
                                    <tr>
                                        <th style="text-align: right"> Nama: </th>
                                        <td> {{ $jenisbiayaproyek->nama }} </td>
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
