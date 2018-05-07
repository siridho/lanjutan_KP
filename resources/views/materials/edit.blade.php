@extends('layouts.template')

@section('title','Master Data Material')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah material #{{ $material->kodeMaterial }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/materials') }}" title="Batal"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Batal</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($material, [
                            'method' => 'PATCH',
                            'url' => ['/materials', $material->kodeMaterial],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('materials.form', ['submitButtonText' => 'Ubah'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection
