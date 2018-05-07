@extends('layouts.template')

@section('title','Edit Data Kelompok Kegiatan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Kelompok Kegiatan #{{ $kelompok_kegiatan->kodeKelompokKegiatan }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/kelompok_kegiatans') }}" title="Batal"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Batal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($kelompok_kegiatan, [
                            'method' => 'PATCH',
                            'url' => ['/kelompok_kegiatans', $kelompok_kegiatan->kodeKelompokKegiatan],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('kelompok_kegiatans.form', ['submitButtonText' => 'Ubah'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
     <!-- end of row -->

</div>
@endsection

