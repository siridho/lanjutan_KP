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
                        <th width="10%" data-field="kode">Username</th>
                        <th width="25%" data-field="nama">Nama</th>
                        <th width="5%" data-field="satuan">Email</th>
                        <th width="20%" data-field="kelompok_utilitas">Level Jabatan</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->level }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
</body>
</html>