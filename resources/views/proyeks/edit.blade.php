@extends('layouts.template')

@section('title','Master Data Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah proyek #{{ $proyek->kodeProyek }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/proyeks') }}" title="Batal"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Batal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($proyek, [
                            'method' => 'PATCH',
                            'url' => ['/proyeks', $proyek->kodeProyek],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('proyeks.form', ['submitButtonText' => 'Ubah'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
<!-- end of row -->

    </div>
</div>
@endsection