@extends('layouts.template')

@section('title','Master Data Customer')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Customer {{ $customer->kodeCustomer }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/customers') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/customers/' . $customer->kodeCustomer . '/edit') }}" title="Edit customer"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['customers', $customer->kodeCustomer],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete customer',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th> Kode Customer </th>
                                        <td> {{ $customer->kodeCustomer }} </td>
                                    </tr>
                                    <tr>
                                        <th> Nama </th>
                                        <td> {{ $customer->nama }} </td>
                                    </tr>
                                    <tr>
                                        <th> Telepon </th>
                                        <td> {{ $customer->telepon }} </td>
                                    </tr>
                                    <tr>
                                        <th> Kontak Nama </th>
                                        <td> {{ $customer->kontakNama }} </td>
                                    </tr>
                                     <tr>
                                        <th> Kontak Telepon </th>
                                        <td> {{ $customer->kontakTelepon }} </td>
                                    </tr>
                                    <tr>
                                        <th> Alamat </th>
                                        <td> {{ $customer->alamat }} </td>
                                    </tr>
                                    <tr>
                                        <th> Area </th>
                                        <td> {{ $customer->area }} </td>
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
