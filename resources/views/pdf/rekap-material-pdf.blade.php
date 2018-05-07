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
		<h3>Laporan Rekapitulasi Material</h3>
		<p id="proyek">Proyek {{$namaproyek}}</p>
		<p>Periode s/d tanggal {{strftime('%d %B %Y', strtotime($tgl))}}</p>
	</div>
	<div class="table-responsive">
       <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
            <thead align="center">
                <tr>
                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Kode</th>
                    <th rowspan="2" style="vertical-align: middle; text-align: center; width: 15%;">Nama Material</th>
                    <th colspan="3" style="vertical-align: middle; text-align: center;">Masuk</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Keluar</th>
                    <th colspan="2" style="vertical-align: middle; text-align: center;">Saldo</th>
                </tr>
                <tr>
                    <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Harga @</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%;">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id='data'>
                @foreach($data as $material_proyek)
                @php 

                $jummasuk= $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl);
                $jumkeluar=$material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl);

                @endphp
                @if($jummasuk||$jumkeluar)
                <tr>
                    <td>{{$material_proyek->kodeMaterial}}</td>
                    <td style="text-align: left;">{{$material_proyek->material->nama}}</td>

                    <td>{{  $material_proyek->totkuantummasuk($material_proyek->kodeMaterial,$tgl) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargamasuk($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->hitungratarata($material_proyek->kodeMaterial,$tgl),0,",",".")  }}</td>

                    <td>{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>

                    <td>{{ $material_proyek->hitungsaldokuantum($material_proyek->kodeMaterial,$tgl) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->hitungsaldoharga($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>
                </tr>
                @endif    
                @endforeach
            </tbody>
            <tfoot id='tfoot'>
                <tr>
                    <td colspan="2">JUMLAH</td>
                    <td></td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtothargamasuk($tgl),0,",",".") }}</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtothargakeluar($tgl),0,",",".") }}</td>
                    <td></td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->grandtotsaldo($tgl),0,",",".") }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>