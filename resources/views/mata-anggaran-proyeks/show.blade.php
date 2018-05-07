@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">mataAnggaranProyek {{ $mataanggaranproyek->kodeKelompokAnggaran }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/mata-anggaran-proyeks') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/mata-anggaran-proyeks/' . $mataanggaranproyek->kodeKelompokAnggaran . '/edit') }}" title="Edit mataAnggaranProyek"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['mataanggaranproyeks', $mataanggaranproyek->kodeKelompokAnggaran],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete mataAnggaranProyek',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr><th> Kode Kelompok Anggaran </th><td> {{ $mataanggaranproyek->kodeKelompokAnggaran }} </td></tr><tr><th> Nama </th><td> {{ $mataanggaranproyek->nama }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
