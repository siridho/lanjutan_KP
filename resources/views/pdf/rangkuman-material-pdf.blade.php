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
		<h3>Laporan Rangkuman Material</h3>
		<p id="proyek">Proyek {{$namaproyek}}</p>
		<p>Periode s/d tanggal {{strftime('%d %B %Y', strtotime($tgl))}}</p>
	</div>
	<div class="table table-responsive">
        <table id="datatable" class="table table-bordered text-center" width="100%">
            <thead align="center">
                <tr>
                    <th style="vertical-align: middle; text-align: center;">Kelompok Material</th>
                    <th style="vertical-align: middle; text-align: center;">Nilai Masuk</th>
                    <th style="vertical-align: middle; text-align: center;">Nilai Keluar</th>
                    <th style="vertical-align: middle; text-align: center;">Nilai Saldo</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id="data">
                    @php 

                    $totmasuk=0;
                    $totkeluar=0;
                    $totsaldo=0;

                    @endphp
                    @foreach($data as $material)
                    @php

                    $jummasuk= $material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
                    $jumkeluar=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);

                    @endphp
                    @if($jummasuk||$jumkeluar)
                    <tr>
                        <td style="vertical-align: middle; text-align: left;">{{$material->kodeJenisBiaya}} - {{$material->nama}}</td>
                        <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtothargamasuk($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                        <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtothargakeluar($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                        <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($material->grandtotsaldo($material->kodeJenisBiaya,$tgl),0,",",".") }}</td>
                    </tr>

                    @php
                    $totmasuk+=$material->grandtothargamasuk($material->kodeJenisBiaya,$tgl);
                    $totkeluar+=$material->grandtothargakeluar($material->kodeJenisBiaya,$tgl);
                    $totsaldo+=$material->grandtotsaldo($material->kodeJenisBiaya,$tgl);
                    @endphp

                    @endif
                    @endforeach
                
            </tbody>
            <tfoot id='tfoot'>
                <tr>
                    <td>JUMLAH</td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totmasuk,0,",",".") }}</td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totkeluar,0,",",".") }}</td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{ number_format($totsaldo,0,",",".") }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>