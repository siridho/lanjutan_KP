@extends('layouts.template')

@section('title','Rekapitulasi Rencana Volume Mingguan')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Rekapitulasi Rencana Volume Mingguan <br> Proyek {{session()->get('namaproyek')}} RAP No. {{substr($rap->nonota, 6)}}
                    </div>
                    <div class="panel-body">
                    <a id="print" onclick="printpdf()" class="btn btn-primary btn-sm" title="CSV">
                            <i class="fa fa-print" aria-hidden="true"></i> Print
                    </a>
                    <input type="hidden" id="urut" value='0'>
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/rekapitulasi-material', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}}
                            <div class="table table-responsive">

                                      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Jenis Biaya</th>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Satuan</th>
                                                <th colspan="{{$lama->akh}}" style="vertical-align: middle; text-align: center;">Volume Rencana (Minggu ke-)</th>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 15%;">jumlah</th>
                                            </tr>
                                            <tr>
                                                @for($i=1;$i<=$lama->akh;$i++)
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">{{$i}}</th>
                                                @endfor
                                                
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">                                   
                                        <tbody id='data'>
                                            @php
                                            $aa=0;
                                            @endphp
                                           @foreach($kodebiaya as $k=>$v)
                                            <tr>
                                                <td>{{ucwords($v)}}</td>
                                                <td>{{$satuan[$k]}}</td>
                                                @for($i=0;$i<$lama->akh;$i++)
                                                <td style="text-align: center;">{{$data[$v][$i]}}</td>
                                                @endfor
                                                <td>{{$sum[$aa]}}</td>
                                            </tr>
                                            @php
                                            $aa++;
                                            @endphp
                                            @endforeach
                                           
                                        </tbody>
                                    </table>
                                </div>
                            {!! Form::close() !!}

<script type="text/javascript"> 


function setdata(param){
    var val=param.value;
    // var spl=val.split('/')
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    // alert(val)
    var url="setrekapmaterial/"+val
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setrekapmaterialfoot/"+val
    $.get(url, function(data){
        $('#tfoot').html(data)
    })

}

function printpdf(){
    var val=$('#tgl').val();
    val=val.toString();
    var spl=val.split('/')
    val = spl[2]+'-'+spl[0]+'-'+spl[1]
    var url="rekapmaterialpdf/"+val
    window.open(url)
}

</script>

                    </div>
                </div>
            </div>
        </div>
        <!-- end of row -->

    </div>
</div>
@endsection
