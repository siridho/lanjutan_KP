<!DOCTYPE html>
<html>
<head>
	<title>	</title>
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
		<h3>Laporan Transaksi Kas</h3>
		<p id="proyek">Proyek {{$namaproyek}}</p>
		<p>Periode tanggal {{strftime('%d %B %Y', strtotime($tglaw))}} s/d {{strftime('%d %B %Y', strtotime($tglakh))}}</p>
	</div>
	<div class="table table-responsive">
          <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
            <thead align="center">
                <tr>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Tanggal</th>
                    <th style="vertical-align: middle; text-align: center; width: 10%;" >Nomor</th>
                    <th style="vertical-align: middle; text-align: center; width: 30%;">Uraian</th>
                    <th style="vertical-align: middle; text-align: center; width: 10%;">Referensi</th>
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Kode - Nama Jenis Biaya</th>
                    <th style="vertical-align: middle; text-align: center; width: 10%;" >Masuk / Keluar</th>
                    <th style="vertical-align: middle; text-align: center; width: 10%;" >Saldo</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id="data">
                @foreach($biayakass as $biayakas)
                <tr class="{{($biayakas->status=='Masuk')?'success':'danger'}}">
                    <td style="text-align: left;">{{$biayakas->tglNota}}</td>
                    <td style="text-align: left;">{{$biayakas->nonota}}</td>
                    <td style="text-align: left;">{{$biayakas->uraian}}</td>
                    <td style="text-align: left;">{{$biayakas->referensi}}</td>
                    <td style="text-align: left;">{{$biayakas->kode}} -</td>
                    <td style="text-align: left;">{{$biayakas->status}}</td>
                    <td style="text-align: right;">Rp {{number_format($biayakas->saldo,0,',','.')}}</td>
                </tr>
                @endforeach
            </tbody>
          
        </table>
    </div>
</body>
</html>