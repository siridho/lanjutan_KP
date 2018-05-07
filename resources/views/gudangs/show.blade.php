@extends('layouts.template')

@section('title','Master Data Gudang')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">gudang {{ $gudang->kodeGudang }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/gudangs') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/gudangs/' . $gudang->kodeGudang . '/edit') }}" title="Edit gudang"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['gudangs', $gudang->kodeGudang],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete gudang',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th> Kode Gudang </th>
                                        <td> {{ $gudang->kodeGudang }} </td>
                                    </tr>
                                    <tr>
                                        <th> Nama </th>
                                        <td> {{ $gudang->nama }} </td>
                                    </tr>
                                    <tr>
                                        <th> Keterangan </th>
                                        <td> {{ $gudang->keterangan }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
     <!-- end of row -->

    </div>
</div>
@endsection
