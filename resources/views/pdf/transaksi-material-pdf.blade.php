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
		<h3>Laporan Transaksi Material</h3>
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
                    <th style="vertical-align: middle; text-align: center; width: 15%;">Kode - Nama Material</th>
                    <th style="vertical-align: middle; text-align: center; width: 10%;" >Masuk / Keluar</th>
                     <th style="vertical-align: middle; text-align: center; width: 10%;" >Kuantum</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id="data">
                @foreach($materials as $material)
                <tr class="{{($material->status=='Masuk')?'success':'danger'}}">
                    <td style="text-align: left;">{{$material->tglNota}}</td>
                    <td style="text-align: left;">{{$material->nonota}}</td>
                    <td style="text-align: left;">{{$material->uraian}}</td>
                    <td style="text-align: left;">{{$material->referensi}}</td>
                    <td style="text-align: left;">{{$material->kode}} - {{$temp->getnama($material->kode)}}</td>
                    <td style="text-align: left;">{{$material->status}}</td>
                    <td style="text-align: right;">{{$material->kuantum}} {{$temp->getsatuan($material->kode)}}</td>
                </tr>
                @endforeach
            </tbody>
          
        </table>
    </div>
</body>
</html>