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
        <h3>Laporan Progres Biaya Proyek : Penggunaan Material</h3>
        <p id="proyek">Proyek {{$namaproyek}}</p>
        <p>Periode tanggal {{strftime('%d %B %Y', strtotime($tglaw))}} s/d {{strftime('%d %B %Y', strtotime($tglakh))}}</p>
    </div>
	<div class="table table-responsive">
          <table id="datatable" class="table table-bordered text-center" style="width: 100%;">
            <thead align="center">
                <tr>
                    <th style="vertical-align: middle; text-align: center;" rowspan="2" style="width: 5%;">Kode</th>
                    <th style="vertical-align: middle; text-align: center;" rowspan="2">Nama Material</th>
                    <th style="vertical-align: middle; text-align: center;" rowspan="2">Harga @ Rata-Rata</th>
                    <th style="vertical-align: middle; text-align: center;" colspan="2">s.d Periode Lalu</th>
                    <th style="vertical-align: middle; text-align: center;" colspan="2">Periode Ini</th>
                    <th style="vertical-align: middle; text-align: center;" colspan="2">s.d. Periode Ini</th>
                </tr>
                <tr>
                    <th style="vertical-align: middle; text-align: center; ">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; " >Harga</th>
                    <th style="vertical-align: middle; text-align: center; ">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; ">Harga</th>
                    <th style="vertical-align: middle; text-align: center; ">Kuantum</th>
                    <th style="vertical-align: middle; text-align: center; " >Harga</th>
                </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="0">                                   
            <tbody id="data">
                @foreach($material_proyeks as $material_proyek)
                @php 

                $hargarata= $material_proyek->hitungratarata($material_proyek->kodeMaterial,$tglakh);
                $tgl=date('Y-m-d', strtotime($tglaw. ' -1 days'));
                
                @endphp
                @if($hargarata)
                <tr>
                    <td>{{$material_proyek->kodeMaterial}}</td>
                    <td style="text-align: left;">{{$material_proyek->material->nama}}</td>
                    <td style="text-align: right;">Rp {{$hargarata}}</td>
                    <td style="text-align: center;"">{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tgl) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tgl),0,",",".") }}</td>
                    <td style="text-align: center;"">{{ $material_proyek->kuantumperiode($material_proyek->kodeMaterial,$tglaw,$tglakh) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->kuantumperiode($material_proyek->kodeMaterial,$tglaw,$tglakh)*$hargarata,0,",",".")}}</td>
                    <td style="text-align: center;"">{{ $material_proyek->totkuantumkeluar($material_proyek->kodeMaterial,$tglakh) }}</td>
                    <td style="text-align: right;">Rp {{ number_format($material_proyek->tothargakeluar($material_proyek->kodeMaterial,$tglakh),0,",",".")}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
            <tfoot id=tfoot>
                <tr>
                    <td colspan="3">JUMLAH</td>
                    <td></td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluar($tgl)}}</td>
                    <td></td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluarperiode($tglaw,$tglakh)}}</td>
                    <td></td>
                    <td style="vertical-align: middle; text-align: right;">Rp {{$material_proyek->grandtothargakeluar($tglakh)}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>