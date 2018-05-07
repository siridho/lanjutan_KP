@extends('layouts.template')

@section('title','Daftar Transaksi Penetralan Kasbon')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div>
          @include('layouts.flash-message')
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Daftar Transaksi Penetralan Kasbon</div>
                    <div class="panel-body">
                        <a href="{{ url('/create-penetralan-kasbon') }}" class="btn btn-success btn-sm" title="Tambah Transaksi Penetralan Kasbon Baru">
                            <i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru
                        </a>

                        <div class="row">
                            <form action="{{url('/nota-penetralan-kasbon/exportcsv')}}" method="POST" class="form-horizontal" enctype='multipart/form-data'>
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
                                        <th style="text-align: center; vertical-align: middle; width: 15%;">No Transaksi Penetralan Kasbon</th>
                                        <th style="text-align: center; vertical-align: middle; width: 15;">Tanggal</th>
                                        <th style="text-align: center; vertical-align: middle; width: 30%;">Pembuat</th>
                                        <th style="text-align: center; vertical-align: middle; width: 40%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notapengeluarankass as $item)
                                    <tr>
                                        
                                        <td>{{ substr($item->nonota,6) }}</td>
                                        <td>{{ $item->tglNota }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <a href="{{ url('/nota-pengeluaran-kass/' . $item->nonota) }}" title="Lihat Transaksi Pengeluaran Kas"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/nota-pengeluaran-kass/' . $item->nonota . '/edit') }}" title="Edit Transaksi Pengeluaran Kas"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                           
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
