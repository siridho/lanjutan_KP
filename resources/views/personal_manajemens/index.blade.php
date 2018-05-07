@extends('layouts.template')

@section('title','Daftar Personal Manajemen')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Personal Manajemen</div>
                    <div class="panel-body">
                        <a href="{{ url('/personal_manajemens/create') }}" class="btn btn-success btn-sm" title="Add New Personal_manajemen">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                       
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nomor Identitas</th>
                                        <th>Bagian</th>
                                        <th>Jabatan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($personal_manajemens as $item)
                                    <tr>
                                        <td>{{ $item->kodePersonalManajemen }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->nomoridentitas }}</td>
                                        <td>{{ $item->bagian }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>
                                            <a href="{{ url('/personal_manajemens/' . $item->id) }}" title="View Personal_manajemen"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/personal_manajemens/' . $item->id . '/edit') }}" title="Edit Personal_manajemen"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/personal_manajemens', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Personal_manajemen',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
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