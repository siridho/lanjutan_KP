@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit MaterialGudang #{{ $materialgudang->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/material-gudangs') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($materialgudang, [
                            'method' => 'PATCH',
                            'url' => ['/material-gudangs', $materialgudang->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('material-gudangs.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
