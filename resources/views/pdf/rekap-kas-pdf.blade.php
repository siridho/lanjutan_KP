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
		<h3>Laporan Rekapitulasi Kas</h3>
		<p id="proyek">Proyek {{$namaproyek}}</p>
		<p>Jenis biaya : 
			@if($jenis==0)
			Semua Jenis Biaya
			@elseif($jenis==2)
			Alat
			@elseif($jenis==3)
			Biaya Operasional Proyek
			@else
			Biaya Umum Proyek
			@endif
		</p>
		<p>Periode s/d tanggal {{strftime('%d %B %Y', strtotime($tgl))}}</p>
	</div>
	<div class="table table-responsive">
	      <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
	        <thead align="center">
	            <tr>
	                <th style="vertical-align: middle; text-align: center; width: 8%;">Kode</th>
	                <th  style="vertical-align: middle; text-align: center; width: 25%;">Nama Material</th>
	                <th style="vertical-align: middle; text-align: center; width: 8%;">Volume</th>
	                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga</th>
	                <th style="vertical-align: middle; text-align: center; width: 15%;">Harga Satuan</th>
	                
	            </tr>
	        </thead>     
	        <input type="hidden" name="no" id="no" value="0">                                   
	        <tbody id='data'>
	          @foreach($biaya_proyeks as $biaya)
	          @if($temp->totkuantum($biaya->kode, $tgl))
	            <tr>
	                <td>{{$biaya->kode}}</td>
	                <td style="vertical-align: middle; text-align: left; width: 25%;">{{$biaya->nama}}</td>
	                <td style="vertical-align: middle; text-align: left; width: 15%;">{{$temp->totkuantum($biaya->kode, $tgl)}} {{$biaya->satuan}}</td>
	                <td style="text-align: right;">Rp {{number_format($temp->totharga($biaya->kode, $tgl),0,",",".")}}</td>
	                <td style="text-align: right;">Rp {{number_format($temp->hitungratarata($biaya->kode, $tgl),0,",",".")}}</td>
	            </tr>
	            @endif
	          @endforeach
	        </tbody>
	        <tfoot id='tfoot'>
	            <td colspan="3">JUMLAH</td>
	                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($temp->grandtotharga(0,$tgl),0,",",".") }}</td>
	                <td></td>
	        </tfoot>
	    </table>
	</div>
</body>
</html>