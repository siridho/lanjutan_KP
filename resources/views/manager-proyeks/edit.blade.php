@extends('layouts.template')

@section('title','Master Data Manager Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit managerProyek #{{ $managerproyek->kodeManager }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/manager-proyeks') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($managerproyek, [
                            'method' => 'PATCH',
                            'url' => ['/manager-proyeks', $managerproyek->kodeManager],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('manager-proyeks.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    <!-- end of row -->

    </div>
</div>
@endsection