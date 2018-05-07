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

                    <div class="panel-heading text-center">Rekapitulasi Rencana Anggaran Mingguan <br> Proyek {{session()->get('namaproyek')}}
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
                                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Kegiatan</th>
                                                <th colspan="{{$lama->akh}}" style="vertical-align: middle; text-align: center;">Rencana Anggaran Minggu-ke (Rp)</th>
                                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 15%;">Total (Rp)</th>
                                            </tr>
                                            <tr>
                                                @for($i=1;$i<=$lama->akh;$i++)
                                                <th style="vertical-align: middle; text-align: center; width: 8%;">{{$i}}</th>
                                                @endfor
                                                
                                            </tr>
                                        </thead> 

                                            @php $grandtot=0;  @endphp
                                        @foreach($rap->detailpekerjaan($rap->nonota) as $pekerjaan)
                                        <tbody id='detail'>
                                            <tr>
                                                <td colspan='1' class="info"><b>{{strtoupper($pekerjaan->Kelompok_kegiatan->nama)}}</b></td>
                                                <td colspan='{{$lama->akh+1}}' class="info" style="vertical-align: middle; text-align: left;"><b>{{ucwords($pekerjaan->keterangan)}}</b></td>
                                            </tr>
  
                                            @foreach($pekerjaan->detailkegiatan as $kegiatan)
                                                <tr>
                                                    <td>{{$kegiatan->Kelompok_kegiatan->kodeKelompokKegiatan}} - {{$kegiatan->Kelompok_kegiatan->nama}} </td>
                                                    @php
                                                    $mingguan=round($kegiatan->totalHarga/$kegiatan->lama,0);
                                                    $aa=$kegiatan->minggu_mulai;
                                                    $batas=$kegiatan->lama+$kegiatan->minggu_mulai-1;
                                                    @endphp

                                                    @for($i=0;$i<$lama->akh;$i++)
                                                    @if($i+1==$aa&&$i+1<=$batas)
                                                	<td style="text-align: center;">{{number_format($mingguan,0,",",".")}}</td>
                                                	@php 
                                                	$aa++;
                                                	$minggu[$i]+=$mingguan
                                                	 @endphp
                                                	@else
                                                	<td style="text-align: center;">-</td>	
                                                	@endif
                                                	@endfor

                                                	<td>{{number_format($kegiatan->totalHarga,0,",",".")}}</td>
                                                    
                                                </tr>
                                            
                                            @endforeach

                                        


                                        @php $grandtot+=$kegiatan->subtotalkegiatan($rap->nonota, $kegiatan->kode_pekerjaan); @endphp
                                        @endforeach

                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td align="right"  style="font-size: 1.3em;">TOTAL</td>
                                                @foreach($minggu as $key=>$m)
                                                <td style="font-size: 1.3em; text-align: right;">
                                                <b>{{number_format($m, 0,",",".")}}</b>
                                                </td>
                                                @endforeach
                                                <td style="font-size: 1.3em; text-align: right;">
                                                <b>{{number_format($grandtot, 0,",",".")}}</b>
                                                </td>
                                            </tr>                                           
                                        </tfoot>
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
