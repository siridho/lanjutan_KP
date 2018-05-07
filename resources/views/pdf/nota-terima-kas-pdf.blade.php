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
            <td width="200px" align="right" style="padding-right:10px;">No Transaksi Penerimaan Kas : </td>
            <td width="200px">{{ substr($notakasmasuk->nonota, 6) }}</td>
            <td width="200px" align="right" style="padding-right:10px; "> Proyek : </td>
            <td width="200px">{{$notakasmasuk->proyek->uraian}}</td>
        </tr>
        <tr height="50px">
            
            <td width="200px" align="right"  style="padding-right:10px;">Pembuat :</td>
            <td width="200px">
               {{$notakasmasuk->karyawan->name}}
            </td>
            <td width="200px" align="right" style="padding-right:10px; "> Tanggal : </td>
            <td width="200px">{{$notakasmasuk->tglNota}}</td>
            </td>
        </tr>
         <tr>
            
        </tr>
      
    </table>
    <br>
    <div class="table table-responsive">
        <table width="100%" class="table table-bordered" id="detail">
            <thead>
                <tr>
                    <th width="70%" style="text-align: center;">Uraian</th>
                    <th width="30%" style="text-align: center;">Saldo</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="1">                                   
            <tbody id='detail'>
            <?php $grantot=0;?>
            @foreach($detailnota as $item)
            <tr >
                    <td width='70%'>{{$item->uraian}}</td>
                    <td width='30%' style="text-align: right;">Rp {{ number_format($item->saldo,0,",",".") }}</td>
            </tr>
            <?php $grantot+=$item->saldo; ?>
            @endforeach
            </tbody>
            <tfoot>
                <tr style="border-top: gray 2px solid;">
                    <td align="right"  style="font-size: 1.3em;"><b>GRAND TOTAL</b></td>
                    <td  style="font-size: 1.3em; text-align: right;">
                    <b>Rp <?php echo number_format($grantot,0,",",".");?></b>
                    </td>
                </tr>                                           
            </tfoot>
        </table>
</body>
</html>