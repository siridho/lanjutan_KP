@extends('layouts.template')

@section('title','Master Data Alat')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Alat #{{ $alat->kodeAlat }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/alats') }}" title="Batal"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Batal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($alat, [
                            'method' => 'PATCH',
                            'url' => ['/alats', $alat->kodeAlat],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('alats.form', ['submitButtonText' => 'Ubah'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
