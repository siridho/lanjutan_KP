@extends('layouts.template')

@section('title','Jenis Pengeluaran Kas Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">jenisPengeluaranKasProyek {{ $jenispengeluarankasproyek->kodePengeluaran }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/jenis-pengeluaran-kas-proyeks') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/jenis-pengeluaran-kas-proyeks/' . $jenispengeluarankasproyek->kodePengeluaran . '/edit') }}" title="Edit jenisPengeluaranKasProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['jenispengeluarankasproyeks', $jenispengeluarankasproyek->kodePengeluaran],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete jenisPengeluaranKasProyek',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> kodePengeluaran </th><td> {{ $jenispengeluarankasproyek->kodePengeluaran }} </td></tr><tr><th> Nama </th><td> {{ $jenispengeluarankasproyek->nama }} </td></tr><tr><th> Satuan </th><td> {{ $jenispengeluarankasproyek->satuan }} </td></tr>
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