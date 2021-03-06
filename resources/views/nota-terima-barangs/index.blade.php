@extends('layouts.template')

@section('title','Nota Terima Barang')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div>
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Nota Terima Barangs</div>
                    <div class="panel-body">
                        <a href="{{ url('/nota-terima-barangs/create') }}" class="btn btn-success btn-sm" title="Tambah Transaksi Penerimaan Barang Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>
                         <div class="row">
                            <form action="{{url('/nota-terima-barangs/exportcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
                                {{csrf_field()}}
                                <div class="col-md-2">
                                    <input class="form-control date-picker birthday" type="text" required name="tglAwal">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control date-picker birthday" type="text" required name="tglAkhir">
                                </div>
                                <div class="col-md-4">
                                    <button class='btn btn-primary pull-left'><i class="fa fa-file-excel-o"></i> Ekspor .xls</button>
                                </div>
                                
                                
                            </form>
                        </div>
                        <br/>
                        <br/>
                            <table id="datatable" class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                       <th style="text-align: center;">No Transaksi</th>
                                       <th style="text-align: center;">Tanggal Transaksi</th>
                                       <th style="text-align: center;">Pembuat</th>
                                       <th style="text-align: center;">Mitra</th>
                                       <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notaterimabarangs as $item)
                                    <tr>
                                        <td>{{ $item->nonota }}</td>
                                        <td>{{ $item->tglNota }}</td>
                                        <td>{{ $item->karyawan->nama }}</td>
                                        <td>{{ $item->mitra->nama }}</td>
                                        <td>
                                            <a href="{{ url('/nota-terima-barangs/' . $item->nonota) }}" title="View NotaTerimaBarang"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                          
                                            <a href="{{ url('/nota-terima-barangs/' . $item->nonota . '/edit') }}" title="Edit NotaBeliMaterial"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                             {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/nota-terima-barangs', $item->nonota],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete NotaTerimaBarang',
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
     <!-- end of row -->

    </div>
</div>
@endsection