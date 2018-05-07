<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
    #proyek{
        text-align: center;
        margin: 0;
    }
    .judul{
    	border-top: 1px solid black;
    	border-bottom: 1px solid black;
    	background-color: #ecf0f1;
    }
    h3,p{
        text-align: center;
        margin: 0;
    }
    table,
    {
      border-collapse:collapse;
    }
    table, tbody tr, th
    {
      border: 1px  solid black;
    }
    tbody td{
        border-right :1px solid black;
    }
    tfoot{
        border:1px  solid black;
        font-weight: bold;
    }
    tfoot td{
        border-right :1px solid black;
    }
    th{
        padding: 3px;
        text-align: center;
    }
    td{
        vertical-align: top;
    }
    
</style>
<body>
	@php
        setlocale(LC_ALL,'IND');
    @endphp
    <div class="panel-heading">
        <h3>Laporan Rekapitulasi Progres Biaya</h3>
        <p id="proyek">Proyek {{$namaproyek}}</p>
        <p>Periode tanggal {{strftime('%d %B %Y', strtotime($tglaw))}} s/d {{strftime('%d %B %Y', strtotime($tglakh))}}</p>
    </div>
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
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul">1. MATERIAL</td>
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
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul">2. ALAT</td>
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
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul">3. UPAH</td>
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
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul">4. BIAYA OPERASIONAL PROYEK</td>
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
                  <td colspan="4" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul">5. BIAYA UMUM PROYEK</td>
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
</body>
</html>