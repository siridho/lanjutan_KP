@extends('layouts.template')

@section('title','Tambah Data Kelompok Kegiatan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Data Kelompok Kegiatan</div>
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

                        {!! Form::open(['url' => '/kelompok_kegiatans', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('kelompok_kegiatans.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
   <!-- end of row -->

</div>
@endsection
