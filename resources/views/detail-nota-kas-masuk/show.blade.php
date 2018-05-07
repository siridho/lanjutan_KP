@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">DetailNotaKasMasuk {{ $detailnotakasmasuk->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/detail-nota-kas-masuk') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/detail-nota-kas-masuk/' . $detailnotakasmasuk->id . '/edit') }}" title="Edit DetailNotaKasMasuk"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['detailnotakasmasuk', $detailnotakasmasuk->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete DetailNotaKasMasuk',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $detailnotakasmasuk->id }}</td>
                                    </tr>
                                    <tr><th> Nonota </th><td> {{ $detailnotakasmasuk->nonota }} </td></tr><tr><th> Uraian </th><td> {{ $detailnotakasmasuk->uraian }} </td></tr><tr><th> NoBaris </th><td> {{ $detailnotakasmasuk->noBaris }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
