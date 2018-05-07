@extends('layouts.template')

@section('title','Home')

@section('content')
<!-- page content -->
<div class="right_col" role="main">

    <div class="row">
       <!-- line graph -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Grafik Data <small>KAS KELUAR MASUK</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content2">
                    <div id="graph_line" style="width:100%; height:300px;"></div>
                  </div>
                </div>
              </div>
              <!-- /line graph -->
  </div>

<!-- Chart.js -->
<script>
  Chart.defaults.global.legend = {
    enabled: false
  };

  var bulan = '{{$bulan}}'
  var kasmasuk= '{{$kasmasuk}}'
  var kaskeluar= '{{$kaskeluar}}'
  var tamanmakampahlawan=0;

  var ddata=[
    @for($i=0;$i<sizeof($data) ;$i++)
      @if($data[$i][1]>1 &&$data[$i][2]>1)
      {month:'{{$data[$i][0]}}',value:'{{$data[$i][1]}}',value2:'{{$data[$i][2]}}'},
      @elseif($data[$i][1]<1 &&$data[$i][2]>1)
      {month:'{{$data[$i][0]}}',value:null,value2:'{{$data[$i][2]}}'},
      @elseif($data[$i][1]>1 &&$data[$i][2]<1)
      {month:'{{$data[$i][0]}}',value:'{{$data[$i][1]}}',value2:null},
      @elseif($data[$i][1]>1 &&$data[$i][2]>1)
      {month:'{{$data[$i][0]}}',value:null,value2:null},
      @endif
    @endfor
  ]
   

  Morris.Line({
          element: 'graph_line',
          xkey: 'month',
          ykeys: ['value', 'value2'],
          labels: ['Kas Masuk','Kas Keluar'],
          hideHover: 'auto',
          lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          data:ddata,
          resize: true
        });
</script>

</div>
<!-- /page content -->
@endsection