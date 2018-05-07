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
    .judul{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        background-color: #ecf0f1;
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
	@php
        setlocale(LC_ALL,'IND');
    @endphp
    <div class="panel-heading">
        <h3 align="center">Rencana Anggaran Pelaksanaan</h3>

        <table width="100%" id="nota">
            <tr height="50px">
                <td width="100px" align="right" style="padding-right:10px;">No RAP: </td>
                <td width="200px">{{$rap->nonota}}</td>
                <td width="100px" align="right"  style="padding-right:10px;">Proyek: </td>
                <td width="200px">
                   {{$rap->proyek->uraian}}
                </td>
            </tr>
            <tr height="50px">
                <td width="100px" align="right" style="padding-right:10px; "> Tanggal Nota: </td>
                <td width="200px">{{ strftime('%d %B %Y', strtotime($rap->tglNota)) }}</td>
                <td width="100px" align="right"  style="padding-right:10px;">Keterangan: </td>
                <td width="200px">
                   {{$rap->keterangan}}
                </td>
            </tr>
            <tr height="50px">
               
                 <td width="100px" align="right"  style="padding-right:10px;">Pembuat: </td>
                <td width="200px">
                   {{$rap->karyawan->nama}}
                </td>
            </tr>
        </table>
    </div>
	 <div class="table table-responsive" id="unsortable">
          <table id="detail" class="table table-bordered text-center" style="width: 100%;">
            <thead>
              <tr>
                <th >Kode</th>
                <th >Pekerjaan</th>
                <th >Minggu Mulai</th>
                <th >Lama</th>
                <th >Volume</th>
                <th >Satuan</th>
                <th  style="text-align: left;">Harga Satuan</th>
                <th  style="text-align: left;">Total Kegiatan</th>
              </tr>
            </thead>     
            <input type="hidden" name="no" id="no" value="1">  
            <br>
            @php $grandtot=0;  @endphp
            @foreach($rap->detailpekerjaan($rap->nonota) as $pekerjaan)                                 
            <tbody id='detail'>
                <tr>
                    
                    <td colspan="8" style="vertical-align: middle; text-align: left; font-weight:bold; " class="judul"><b>{{strtoupper($pekerjaan->Kelompok_kegiatan->nama)}}</b></td>
                
                </tr>
         
                @foreach($pekerjaan->detailkegiatan as $kegiatan)
                    <tr>
                        <td align="center">{{$kegiatan->Kelompok_kegiatan->kodeKelompokKegiatan}}</td>
                        <td align="left">{{$kegiatan->Kelompok_kegiatan->nama}}</td>
                        <td align="center">{{$kegiatan->minggu_mulai}}</td>
                        <td align="center">{{$kegiatan->lama}}</td>
                        <td align="center">{{$kegiatan->volume}}</td>
                        <td align="center">{{$kegiatan->Kelompok_kegiatan->satuan}}</td>
                        <td align="right">Rp {{number_format($kegiatan->hargaSat,0,",",".")}} </td>
                        <td align="right">Rp {{number_format($kegiatan->totalHarga,0,",",".")}}</td>
                    </tr>
                
                @endforeach

            <tr>
                <td align="right"   style="border-top: solid black 1px;" colspan="7"><b>TOTAL</b></td>
                <td align="right"  style="border-top: solid black 1px;"><b>Rp {{ number_format($kegiatan->subtotalkegiatan($rap->nonota, $kegiatan->kode_pekerjaan),0,",",".") }}</b></td>
            </tr>

            </tbody>

            @php $grandtot+=$kegiatan->subtotalkegiatan($rap->nonota, $kegiatan->kode_pekerjaan); @endphp
            @endforeach
            <tfoot>
                <tr>
                    <td align="right"  style="font-size: 1.3em;" colspan="7">GRANDTOTAL</td>
                    <td style="font-size: 1.3em; text-align: right;">
                    <b>Rp {{number_format($grandtot,0,",",".")}}</b>
                    </td>
                </tr>                                           
            </tfoot>
          
        </table>
    </div>
</body>
</html>