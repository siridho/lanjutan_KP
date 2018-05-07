@php
use App\DetailPenggunaanMaterial;
use App\DetailTerimaBarang;
@endphp
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
        <h3>Laporan Kartu Stok</h3>
        <p id="proyek">Proyek {{$namaproyek}}</p>
        <p>s/d tanggal {{strftime('%d %B %Y', strtotime(date('Y-m-d')))}}</p>
    </div>
	<div class="table table-responsive">
          <table width="100%">
            <thead align="center">
                <tr>
                    <th style="vertical-align: middle; text-align: center;">Tanggal</th>
                    <th style="vertical-align: middle; text-align: center;">Nomor</th>
                    <th style="vertical-align: middle; text-align: center;">Uraian</th>
                    <th style="vertical-align: middle; text-align: center;">Masuk</th>
                    <th style="vertical-align: middle; text-align: center;">Keluar</th>
                    <th style="vertical-align: middle; text-align: center;">Saldo</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id="detailStok">
            @php
            $saldo=0;
            $kode='';
            $mater;
            @endphp
            @foreach ($materialss as $material) {
            @php
                $pos = strpos($material->nonota,'PM');
                $kode=$id;
                 $mater=DetailTerimaBarang::detailKartuTerima($material->nonota,$id);
            @endphp
            @if($mater)
                <tr>
                <td>{{strftime('%d %B %Y', strtotime($mater->tglNota))}}</td>
                <td>{{$kode}}</td>
                <td>{{$mater->keterangan}}</td>
               
                <td>{{$mater->jumlah}} {{$mater->material->satuan}}</td>
                <td></td>
                @php
                $saldo=round($saldo,4)+round($mater->jumlah,4);
               @endphp
               <td>{{$saldo}}</td>
            </tr>
            @else
                @php
                $mater=DetailPenggunaanMaterial::detailKartuGuna($material->nonota,$id);
                @endphp
                <tr>
                <td>{{strftime('%d %B %Y', strtotime($mater->tglNota))}}</td>
                <td>{{$kode}}</td>
                <td>{{$mater->keterangan}}</td>
               
                <td></td>
                <td>{{$mater->jumlah}} {{$mater->material->satuan}}</td>'
                @php
                    $saldo=round($saldo,4)-round($mater->jumlah,4);
                @endphp
               <td>{{$saldo}}</td>
            </tr>
            @endif
            @endforeach
            </tbody>
            <tfoot id="detailStokFoot">
                <tr>
                    <td colspan='3' style='border-top: 2px solid gray;'>JUMLAH</td>
                    <td style='border-top: 2px solid gray;'>{{$masuk}}</td>
                    <td style='border-top: 2px solid gray;'>{{$keluar}}</td>
                    <td style='border-top: 2px solid gray;'>{{$saldo}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>