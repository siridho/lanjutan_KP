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
            <td width="100px" align="right" style="padding-right:10px;"> No Nota : </td>
            <td width="200px">{{$notaterimabarang->nonota}}</td>
            <td width="100px" align="right"  style="padding-right:10px;">Proyek : </td>
            <td width="200px">
            {{$notaterimabarang->proyek->uraian}}
        </tr>
        <tr height="50px">
            <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota : </td>
            <td width="200px">{{$notaterimabarang->tglNota}}</td>
            <td width="100px" align="right"  style="padding-right:10px;">Referensi  : </td>
            <td width="200px">
                {{$notaterimabarang->nonota_beli}}
            </td>
        </tr>
        <tr height="50px">
            <td width="100px" align="right"  style="padding-right:10px;">Mitra : </td>
            <td width="200px">
                {{$notaterimabarang->mitra->nama}}
            </td>
        </tr>
    </table>
    <br>
    <div class="table table-responsive">
          <table width="100%" id="detail">
            <thead>
            	<tr>
	                <th width="30%">Material</th>
	                <th width="30%">Keterangan</th>
	                <th width="10%">Jumlah</th>
            	</tr>                                                  
            </thead>     
            <input type="hidden" name="no" id="no" value="1">                                   
            <tbody id='detail'>
                @foreach($detailnota as $item)
                <tr>
                    <td width='30%'>
                      {{$item->material->kodeMaterial}} - {{$item->material->nama}}
                    </td>
                    <td width="30%">{{$item->keterangan}}</td>
                    <td width='10%'> {{$item->jumlah}} {{$item->material->satuan}}</td>
                       
                </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>