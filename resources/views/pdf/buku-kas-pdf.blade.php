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
		padding: 3px;
	}
	tbody td
	{
		border-right :1px solid black;
		padding: 3px;
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
	<div class="panel-heading">
		<h3>Laporan Buku Kas</h3>
		<p id="proyek">Proyek {{session()->get('namaproyek')}}</p>
		<p> Periode tanggal {{strftime('%d %B %Y', strtotime($tglaw))}} s/d {{strftime('%d %B %Y', strtotime($tglakh))}}</p>
	</div>
	<div class="table-responsive">
		<table width="100%">
            <thead align="center">
                <tr>
                    <th>Tanggal</th>
                    <th>Nomor Transaksi</th>
                    <th>Uraian</th>
                    <th>Kode Biaya</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Saldo</th>
                </tr>
            </thead>                                       
            <tbody id="data">
                <tr>
                    <td>{{$tglaw}}</td>
                    <td></td>
                    <td style="text-align: left; font-weight:bold;width: 20%;">SALDO AWAL</td>
                    <td style="text-align: left;"></td>
                    <td style="text-align: right;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($temp->getsaldoawal($tglaw),0,",",".")}}</td>
                    <td style="text-align: right;"></td>
                    <td style="text-align: right;"></td>
                </tr>
                @foreach($kas as $ka)
                @php 
                if(!$ka->kode){
                    $saldo+=$ka->saldo;
                }
                else{
                    $saldo-=$temp->tothargasaat($ka->kode, $ka->tglNota,$ka->nonota, $ka->no_baris);
                }
                
                @endphp
                <tr>
                    <td style="width: 10%;">{{$ka->tglNota}}</td>
                    <td style="text-align: left;">{{$ka->nonota}}</td>
                    <td style="text-align: left;">{{$ka->uraian}}</td>
                    <td style="text-align: left;">{{$ka->kode}}</td>
                    <td style="text-align: right;">{{(!$ka->kode)?'Rp '.number_format($ka->saldo,0,",","."):'-'}}</td>
                    <td style="text-align: right;"> {{$ka->kode?'Rp '.number_format($temp->tothargasaat($ka->kode, $ka->tglNota, $ka->nonota , $ka->no_baris),0,",","."):'-'}}</td>
                    <td style="text-align: right;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($saldo,0,",",".")}}</td>
                </tr>
                @endforeach

            @php
                $saldo=$temp->getsaldoakhir($tglaw,$tglakh);
            @endphp

            </tbody>
            <tfoot id=tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">JUMLAH</td>
                    <td style="text-align: right;">Rp {{number_format($temp->grantotmasukkas($tglaw,$tglakh),0,",",".")}}</td>
                    <td style="text-align: right;">Rp {{number_format($temp->grantotkeluarkas($tglaw,$tglakh),0,",",".")}}</td>
                    <td style="text-align: right;{{($saldo<=0)? 'color:red;':''}}">Rp {{number_format($saldo,0,",",".")}}</td>
                </tr>
            </tfoot>
        </table>
	</div>
</body>
</html>