@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit DetailNotaKasMasuk #{{ $detailnotakasmasuk->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/detail-nota-kas-masuk') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($detailnotakasmasuk, [
                            'method' => 'PATCH',
                            'url' => ['/detail-nota-kas-masuk', $detailnotakasmasuk->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('detail-nota-kas-masuk.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
