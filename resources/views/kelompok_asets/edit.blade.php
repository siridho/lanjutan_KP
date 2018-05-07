@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Kelompok_aset #{{ $kelompok_aset->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/kelompok_asets') }}" title="Batal"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Batal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($kelompok_aset, [
                            'method' => 'PATCH',
                            'url' => ['/kelompok_asets', $kelompok_aset->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('kelompok_asets.form', ['submitButtonText' => 'Ubah'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
