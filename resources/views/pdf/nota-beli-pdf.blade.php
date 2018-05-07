<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
	#nota, #detail
	{
	  border-collapse:collapse;
	  
	}
	#detail, tbody tr, th
	{
	  border: 1px  solid black;
	}
	#detail tbody td{
		border-right :1px solid black;
	}
	th{
    	padding: 3px;
    	text-align: center;
	}
	td{
        vertical-align: top;
    }
    tfoot{
		border:1px  solid black;
		font-weight: bold;
	}
    tfoot td{
        border-right :1px solid black;
        padding: 3px;
    }
</style>
<body>
	<div>
		<table width="100%" id="nota">
	        <tr height="50px">
	            <td width="100px" align="right" style="padding-right:10px;">No Nota: </td>
	            <td width="200px">{{$notabelimaterial->nonota}}</td>
	            <td width="100px" align="right"  style="padding-right:10px;">Proyek: </td>
	            <td width="200px">
	               {{$notabelimaterial->proyek->uraian}}
	            </td>
	        </tr>
	        <tr height="50px">
	            <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota: </td>
	            <td width="200px">{{ strftime('%d %B %Y', strtotime($notabelimaterial->tglNota)) }}</td>
	            <td width="100px" align="right"  style="padding-right:10px;">Pembuat: </td>
	            <td width="200px">
	               {{$notabelimaterial->karyawan->nama}}
	            </td>
	        </tr>
	        <tr height="50px">
	            <td width="100px" align="right"  style="padding-right:10px;">Mitra Kerja: </td>
	            <td width="200px">
	               {{$notabelimaterial->mitra->nama}}
	            </td>
	            <td width="100px" align="right"  style="padding-right:10px;">Status: </td>
	            <td width="200px">
	               {{$notabelimaterial->status}}
	            </td>
	        </tr>
	    </table>
	    <br>
        <table width="100%" id="detail">
            <thead>
        		<tr>
        			<th>Material</th>
	                <th>Keterangan</th>
	                <th>Jumlah</th>
	                <th>Harga</th>
	                <th>Sub Total</th>
        		</tr>
            </thead>                                
            <tbody>
            <?php $grantot=0;?>
            @foreach($detailnota as $item)
	            <tr>
	                <td>{{$item->material->kodeMaterial}}-{{$item->material->nama}}</td>
	                <td>{{$item->keterangan}}</td>
	                <td>{{$item->qty}} {{$item->material->satuan}}</td>
	                <td style="text-align: right;">Rp {{number_format($item->harga,0,",",".") }}</td>
	                <td style="text-align: right;">Rp {{number_format($item->qty*$item->harga,0,",",".") }}</td>
	            </tr>
            <?php $grantot+=$item->qty*$item->harga; ?>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">GRAND TOTAL</td>
                    <td style="text-align: right;"><b>Rp {{number_format($grantot,0,",",".")}}</b></td>
                </tr>
               
            </tfoot>
        </table>
    </div>
</body>
</html>