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
                <td width="200px" align="right" style="padding-right:10px;">No. Memo Proyek : </td>
                <td width="200px">{{ $memoProyek->nonota }}</td>
                <td width="200px" align="right" style="padding-right:10px; "> Proyek : </td>
                <td width="200px">{{$memoProyek->proyek->uraian}}</td>
            </tr>
            <tr height="50px">
                
                <td width="200px" align="right"  style="padding-right:10px;">Pembuat :</td>
                <td width="200px">
                   {{$memoProyek->karyawan->nama}}
                </td>
                <td width="200px" align="right" style="padding-right:10px; "> Tanggal Transaksi: </td>
                <td width="200px">{{$memoProyek->tgl}}</td>
                </td>
            </tr>
             <tr>
                
            </tr>
          
        </table>
        <br>
        <div class="table table-responsive">
            <table class="table table-bordered" width="100%"  id="detail">
                <thead>
                    <!-- <th>No</th> -->
                    <tr>
		                <th width="60%" style="text-align: center;">Uraian</th>
		                <th width="40%" style="text-align: center;">Nilai</th>
                    </tr>
                </thead>                                     
                <tbody id='detail'>
                
                @foreach($detailmemo as $item)
                <tr >
                        <td width='70%'>{{$item->uraian}}</td>
                        <td width='30%' style="text-align: right;">Rp {{ number_format($item->nilai,0,",",".") }}</td>
                </tr>
                @endforeach
                </tbody>
              
            </table>
        </div>
        </table>
    </div>
</body>
</html>