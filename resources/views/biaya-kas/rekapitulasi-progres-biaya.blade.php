@extends('layouts.template')

@section('title','Rekapitulasi Progres Biaya Proyek')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    
    <div >

        <!-- row -->
        <div class="row" id="section-to-print">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-heading text-center">Rekapitulasi Progres Biaya Proyek <br> {{session()->get('namaproyek')}}
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
                      <!--    {!! Form::open(['url' => '/rekapitulasi-kas', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                                {{csrf_field()}} -->

                                <div class="row">
                                    <div class="col-md-offset-5 col-md-2 text-center">
                                        <p>Tanggal</p>        
                                        <input type="text" name="mulai" id="tglaw" onchange="setdata(this)" class="form-control date-picker birthday" value="{{date('m/d/Y',strtotime($tglaw))}}">
                                        
                                        s.d
                                        <input type="text" name="selesai" id="tglakh" onchange="setdata(this)" class="form-control date-picker birthday" value="{{date('m/d/Y',strtotime($tglakh))}}">
                                    </div>
                                </div>                                
                                <br>
                                <div class="table table-responsive" id="unsortable">
                                      <table id="" class="table table-bordered text-center" style="width: 100%;">
                                        <thead align="center">
                                            <tr>
                                                <th style="vertical-align: middle; text-align: center; width: 15%;">Nama Biaya</th>
                                                <th style="vertical-align: middle; text-align: center; width: 10%;" >S.d minggu lalu</th>
                                                <th style="vertical-align: middle; text-align: center; width: 30%;">Periode Ini</th>
                                                <th style="vertical-align: middle; text-align: center; width: 10%;">S.d Periode Ini</th>
                                            </tr>
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">
                                        @php
                                        $tgl=date('Y-m-d',strtotime($tglaw . " - 1 day"));
                                        @endphp              
                                        <tbody id="data">
                                          <tr>
                                              <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">1. MATERIAL</td>
                                          </tr>
                                          @foreach($materials as $item)
                                          @php
                                            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
                                            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
                                          @endphp
                                          @if($lalu||$ini)
                                          <tr>
                                              <td style="vertical-align: middle; text-align: left;">{{$item->kodeJenisBiaya}} - {{$item->nama}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".")}}</td>
                                          </tr>
                                          @endif
                                          @endforeach
                                          <tr style="">
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL MATERIAL</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">2. ALAT</td>
                                          </tr>
                                          @foreach($alats as $item)
                                          @php
                                            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
                                            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
                                          @endphp
                                          @if($lalu||$ini)
                                          <tr>
                                              <td style="vertical-align: middle; text-align: left;">{{$item->kodeJenisBiaya}} - {{$item->nama}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".")}}</td>
                                          </tr>
                                          @endif
                                          @endforeach
                                           <tr>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL ALAT</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">3. UPAH</td>
                                          </tr>
                                          @foreach($upahs as $item)
                                          @php
                                            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
                                            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
                                          @endphp
                                          @if($lalu||$ini)
                                          <tr>
                                               <td style="vertical-align: middle; text-align: left;">{{$item->kodeJenisBiaya}} - {{$item->nama}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".")}}</td>
                                          </tr>
                                          @endif
                                          @endforeach
                                           <tr>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL UPAH</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">4. BIAYA OPERASIONAL PROYEK</td>
                                          </tr>
                                          @foreach($bops as $item)
                                          @php
                                            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
                                            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
                                          @endphp
                                          @if($lalu||$ini)
                                          <tr>
                                               <td style="vertical-align: middle; text-align: left;">{{$item->kodeJenisBiaya}} - {{$item->nama}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".")}}</td>
                                          </tr>
                                          @endif
                                          @endforeach
                                           <tr>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL BIAYA OPERASIONAL PROYEK</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right; font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") }}</td>
                                          </tr>
                                          <tr>
                                              <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="info">5. BIAYA UMUM PROYEK</td>
                                          </tr>
                                          @foreach($bups as $item)
                                          @php
                                            $lalu=$item->totkeluarsaat($item->kodeJenisBiaya,$tgl);
                                            $ini=$item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh);
                                          @endphp
                                          @if($lalu||$ini)
                                          <tr>
                                               <td style="vertical-align: middle; text-align: left;">{{$item->kodeJenisBiaya}} - {{$item->nama}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".")}}</td>
                                              <td style="vertical-align: middle; text-align: right;">Rp {{number_format($item->totkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".")}}</td>
                                          </tr>
                                          @endif
                                          @endforeach
                                           <tr>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">SUBTOTAL BIAYA UMUM PROYEK</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->grandtotkeluar($item->kodeJenisBiaya,$tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->grandtotkeluarsaat($item->kodeJenisBiaya,$tglakh),0,",",".") }}</td>
                                          </tr>
                                          
                                        </tbody>

                                        <tfoot id='tfoot'>
                                          <tr>
                                              <td style="border-top: 2px gray solid; border-bottom: 2px gray solid; vertical-align: middle; text-align: left; font-weight:bold; ">TOTAL BIAYA</td>
                                              <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->totbiayakeluarsaat($tgl),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->totbiayakeluar($tglaw,$tglakh),0,",",".") }}</td>
                                              <td style="border-top: 2px gray solid; border-bottom: 2px gray solid;  vertical-align: middle; text-align: right;font-weight:bold;">Rp {{ number_format($item->totbiayakeluarsaat($tglakh),0,",",".") }}</td>
                                          </tr>
                                        </tfoot>
                                      
                                    </table>
                                </div>
                         <!--    {!! Form::close() !!} -->


<script type="text/javascript"> 

function setdata(param){
    var tglaw=$('#tglaw').val()
    var tglakh=$('#tglakh').val()

    valaw=tglaw.toString();
    var splaw=tglaw.split('/')
    valaw = splaw[2]+'-'+splaw[0]+'-'+splaw[1]

    valakh=tglakh.toString();
    var splakh=tglakh.split('/')
    valakh = splakh[2]+'-'+splakh[0]+'-'+splakh[1]
        
    var url="setprogres/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#data').html(data)
    })

    url="setprogresfoot/"+valaw+"/"+valakh
    $.get(url, function(data){
        $('#tfoot').html(data)
    })
}

function printpdf(){
    var tglaw=$('#tglaw').val()
    var tglakh=$('#tglakh').val()

    valaw=tglaw.toString();
    var splaw=tglaw.split('/')
    valaw = splaw[2]+'-'+splaw[0]+'-'+splaw[1]

    valakh=tglakh.toString();
    var splakh=tglakh.split('/')
    valakh = splakh[2]+'-'+splakh[0]+'-'+splakh[1]
    var url="rekapprogresbiayapdf/"+valaw+"/"+valakh
    window.open(url)
}

 </script>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


