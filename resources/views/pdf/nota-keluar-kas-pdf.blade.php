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
	<table width="100%" id="nota">
        <tr height="50px">
            <td width="200px" align="right" style="padding-right:10px;"> No Transaksi Pengeluaran Kas : </td>
            <td width="200px">{{ substr($notapengeluarankass->nonota,6) }}</td>
            <td width="100px" align="right" style="padding-right:10px; "> Proyek : </td>
            <td width="200px">{{ $notapengeluarankass->proyek->uraian }}</td>
        </tr>
        <tr height="50px">
            <td width="100px" align="right" style="padding-right:10px; "> Tanggal Transaksi : </td>
            <td width="200px">{{ strftime('%d %B %Y', strtotime($notapengeluarankass->tglNota)) }}</td>
            <td width="100px" align="right"  style="padding-right:10px;">Status : </td>
            <td width="200px">
               {{ $notapengeluarankass->status_nota }}
            </td>
        </tr>
        <tr height="50px">
            <td width="100px" align="right"  style="padding-right:10px;">Pembuat : </td>
            <td width="200px">
               {{ $notapengeluarankass->karyawan->name }}
            </td>
        </tr>
    </table>
    <br>
    <div class="table table-responsive">
        <table class="table table-bordered" width="100%" id="detail">
            <thead>
               	<tr>
               		<th width="25%" style="text-align: center;">Uraian</th>
	                <th width="15%" style="text-align: center;">Kode</th>
	                <th width="10%" style="text-align: center;">Jumlah</th>
	                <th width="20%" style="text-align: center;">Harga</th>
	                <th width="30%" style="text-align: center;">Sub Total</th>
               	</tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="1">                                   
            <tbody id='detail'>
            <?php $grantot=0;?>
            @foreach($detailnota as $item)
            <tr >
                    <td width='25%'>{{$item->uraian}}</td>
                    <td width='15%' style="text-align: center;">{{$item->kodeBiayaKas?$item->kodeBiayaKas:$item->kodeAlat}}</td>
                    <td width='10%' style="text-align: center;">{{$item->jumlah}}</td>
                    <td width='20%' style="text-align: right;">Rp {{ number_format($item->harga,0,",",".")}}</td>
                    <td width='30%' style="text-align: right;">Rp {{ number_format($item->jumlah*$item->harga,0,",",".")}}</td>
            </tr>
            <?php $grantot+=$item->jumlah*$item->harga; ?>
            @endforeach
            </tbody>
            <tfoot>
                <tr style="border-top: gray 2px solid">
                    <td align="right" colspan="4" style="font-size: 1.3em; text-align: right;"><b>GRAND TOTAL</b></td>
                    <td  style="font-size: 1.3em; text-align: right;">
                    <b>Rp <?php echo number_format($grantot,0,",","."); ?></b>
                    </td>
                </tr>
            </tfoot>
        </table>
</body>
</html>