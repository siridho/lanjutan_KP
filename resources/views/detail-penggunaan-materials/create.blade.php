@extends('layouts.template')

@section('title','Detail Penggunaan Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New DetailPenggunaanMaterial</div>
                    <div class="panel-body">
                        <a href="{{ url('/detail-penggunaan-materials') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/detail-penggunaan-materials', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('detail-penggunaan-materials.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
   <!-- end of row -->

    </div>
</div>
@endsection
