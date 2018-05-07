<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>PT. CIPTA ANUGERAH INDOTAMA | @yield('title')</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="{{ asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- starrr -->
    <link href="{{ asset('vendors/starrr/dist/starrr.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">


    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="{{ asset('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('vendors/google-code-prettify/src/prettify.js') }}"></script>
    <!-- jQuery Tags Input -->
    <script src="{{ asset('vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Parsley -->
    <script src="{{ asset('vendors/parsleyjs/dist/parsley.min.js') }}"></script>
    <!-- Autosize -->
    <script src="{{ asset('vendors/autosize/dist/autosize.min.js') }}"></script>
    <!-- jQuery autocomplete -->
    <script src="{{ asset('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
    <!-- starrr -->
    <script src="{{ asset('vendors/starrr/dist/starrr.js') }}"></script>
     <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js')}}"></script>

    <!-- morris.js -->
    <script src="{{ asset('vendors/raphael/raphael.min.js')}}"></script>
    <script src="{{ asset('vendors/morris.js/morris.min.js')}}"></script>
    <!-- end morris.js -->
    <!-- pengin aja -->
    <style type="text/css">
    #load {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://sampsonresume.com/labs/pIkfp.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading #load {
    display: block;
}
</style>
    <!-- udah -->
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 col-xs-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ url('/home') }}" class="site_title"><span>PT CAI</span></a>
            </div>
            <div class="clearfix"></div>
            <div class="profile clearfix">
         
              <div class="clearfix"></div>
            </div>
            <br />
                @include('layouts.sidebar')
          </div>
        </div>
        @include('layouts.topnavigation') 
        @yield('content')
        @include('layouts.footer')
      </div>
    </div>

 
   
    <!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.min.js') }}"></script>
    
    <!-- token mismatch -->
    <script type="text/javascript">
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });
    </script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable({
            'lengthMenu':[[-1,10,25,50,100],['All',10,25,50,100]],
          
          'iDisplayLength':10
        });

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable({
             'lengthMenu':[[-1,10,25,50,100],['All',10,25,50,100]],
         
          'iDisplayLength':10
        });

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
         
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->

    <script>
    $(document).ready(function() {
        $('.inp').hide()

        
    })

    //tampilkan preview gambar upload
    // function readURL(input) {
    //     if (input.files && input.files[0]) {
    //         var reader = new FileReader()
    //         var id = input.id
    //         var itung = id.split('profile-img')
    //         $('#profile-img-tag'+itung[1]).show()

    //         reader.onload = function (e) {
    //             $('#profile-img-tag'+itung[1]).attr('src', e.target.result)
    //         }
    //         reader.readAsDataURL(input.files[0])
    //     }
    // }

    // function gambarpreview(gambar){
    //     readURL(gambar)
    // }
    //end of tampilkan preview gambar upload
    
    $(function(){  
      $('input[type="time"][value="now"]').each(function(){    
        var d = new Date(),        
            h = d.getHours(),
            m = d.getMinutes()
        if(h < 10) h = '0' + h 
        if(m < 10) m = '0' + m 
        $(this).attr({
          'value': h + ':' + m
        });
      });
    });

    var itung = 1;
    var jumlah = 1;
    function tambahgambar(){
        event.preventDefault();
        if(jumlah<3){
            itung++
            jumlah++
            var anu = '<div class="form-group" id="subdivgambar'+itung+'"><label for="nama" class="col-md-3 col-xs-3 control-label">Pilih Gambar '+itung+'</label>'+
                            '<div class="col-md-5 col-xs-5">'+
                              
                               '<img src="" id="profile-img-tag'+itung+'" height="100px" />'+
                            '</div>'+
                            '<button type="submit" class="btn btn-danger" onclick="hapusgambar('+itung+')"> X </button>'+
                        '</div>'
            $('#divgambar').append(anu)
            $('#profile-img-tag'+itung).hide()
        }
        if(jumlah == 3){
            $('#buttontambahgambar').hide()     
        }
    }

    function hapusgambar(parama){
        jumlah--
        $('#buttontambahgambar').show() 
        $('#subdivgambar'+parama).remove()
    }

    //ubah isi subkategori sesuai dengan pilihan kategori
    $('#kategori').on('change', function(){
        var idpass = $(this).val()
        //alert(idpass)
        var url="../loadsubkategori/"+idpass;
        $.get(url, function(data){
            //alert(data)
            $('#subkategori').html(data)
        })
    })

    $('#tglmulai').on('change',function(){
        var ini = $(this).val();
        $('#tglselesai').attr('min',ini)
    })

    $('#jamselesai').on('change', function(){
        var tglmulai = $('#tglmulai').val()
        var tglselesai = $('#tglselesai').val()

        if(tglmulai == tglselesai){
            var jammulai = $('#jammulai').val()
            var splitjammulai = jammulai.split(':')

            var jamselesai = $('#jamselesai').val()
            var splitjamselesai = jamselesai.split(':')

            var jam2 = (parseInt(splitjammulai[0]) + 1)%24

            var jam = (parseInt(splitjammulai[0]) + 1)%24

            // if(jam2 <= jam){
            //     if(jam < 10){
            //         jam = "0"+jam
            //     }

            //     var jambaru=jam+':'+splitjammulai[1]

            //     $('#jamselesai').val(jambaru)
            // }
            $('#jamselesai').attr('min', jambaru)
        }
        else{
            $('#jamselesai').removeAttr('min')   
        }
    })


  // bootstrap-daterangepicker
      $(document).ready(function() {
        $('.birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    
    // bootstrap-daterangepicker

     window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 3000);
</script>
    
  </body>
</html>
