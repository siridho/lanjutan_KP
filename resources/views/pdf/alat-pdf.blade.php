<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
	h3{
		text-align: center;
	}
	/*table{
		border:1px solid black;
	}
	th{
		border-bottom: 1px solid black;
	}*/
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
	th{
    	padding: 3px;
    	text-align: center;
	}
    td{
        vertical-align: top;
    }
	
</style>
<body>
	<div class="panel-heading"><h3>Daftar Data Referensi Alat</h3></div>
	<div class="table-responsive">
            <table width="100%" class="table table-bordered" data-toggle="table" data-show-print="true">
                <thead>
                    <tr>
                        <th width="10%" data-field="kode">Kode Alat</th>
                        <th width="25%" data-field="nama">Nama</th>
                        <th width="5%" data-field="satuan">Satuan</th>
                        <th width="20%" data-field="kelompok_utilitas">Kelompok Utilitas</th>
                        <th width="10%" data-field="masa_pakai">Masa Pakai</th>
                        <th width="30%" data-field="keterangan">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->kodeAlat }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->Satuan }}</td>
                        <td>{{ $item->kelompokUtilitas }} - {{$item->getKelompokUtilitas($item->kodeAlat)}}</td>
                         <td>{{ $item->masapakai }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
</body>
</html>