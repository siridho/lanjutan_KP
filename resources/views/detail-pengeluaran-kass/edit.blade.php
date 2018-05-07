@extends('layouts.template')

@section('title','Detail Pengeluaran Kas')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit DetailPengeluaranKass #{{ $detailpengeluarankass->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/detail-pengeluaran-kass') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($detailpengeluarankass, [
                            'method' => 'PATCH',
                            'url' => ['/detail-pengeluaran-kass', $detailpengeluarankass->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('detail-pengeluaran-kass.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
