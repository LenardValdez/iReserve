<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iRESERVE</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/daterangepicker.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" href="css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" href="css/select.dataTables.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/skin-blue.min.css">
    <link rel="stylesheet" href="css/fullcalendar-core.min.css">
    <link rel="stylesheet" href="css/fullcalendar-list.min.css">
    <link rel="stylesheet" href="css/fullcalendar-timeline.min.css">
    <link rel="stylesheet" href="css/fullcalendar-resource-timeline.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
      .notifications-menu > .dropdown-menu > li .menu > li > a {
        white-space: normal !important;
      }
  
      .gutter-10.row {
        margin-right: -5px;
        margin-left: -5px;
      }
      .gutter-10 > [class^="col-"], .gutter-10 > [class^=" col-"] {
        padding-right: 5px;
        padding-left: 5px;
      }
    </style>

    <script src="js/adminlte_js/jquery.min.js"></script>
    <script src="js/adminlte_js/jquery-ui.min.js"></script>
    <script src="js/adminlte_js/moment.min.js"></script> <!--DATE FORMAT BEING USED BY DATERANGEPICKER-->
    <script src="https://use.fontawesome.com/5c5dc87b32.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="js/adminlte_js/bootstrap.min.js"></script>
    <script src="js/adminlte_js/popper.min.js"></script>
    <script src="js/adminlte_js/tooltip.min.js"></script>
    <script src="js/adminlte_js/pdfmake.min.js"></script>
    <script src="js/adminlte_js/vfs_fonts.js"></script>
    <script src="js/adminlte_js/jquery.dataTables.min.js"></script>
    <script src="js/adminlte_js/dataTables.bootstrap.min.js"></script>    
    <script src="js/adminlte_js/dataTables.buttons.min.js"></script>
    <script src="js/adminlte_js/buttons.flash.min.js"></script>
    <script src="js/adminlte_js/buttons.html5.min.js"></script>
    <script src="js/adminlte_js/dataTables.select.min.js"></script>
    <script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
    <script src="js/adminlte_js/adminlte.min.js"></script>
    <script src="js/adminlte_js/daterangepicker.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
    <script src="js/adminlte_js/bootstrap-datepicker.min.js"></script> <!--JS FOR DATE AND TIME RANGE-->
    <script src="js/adminlte_js/select2.full.min.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
    <script src="js/adminlte_js/fullcalendar-core.min.js"></script> <!--CHANGE FORM DATE AND TIME FORMAT TO ISO8601 STRING USING moment().toISOString()-->
    <script src="js/adminlte_js/fullcalendar-list.min.js"></script>
    <script src="js/adminlte_js/fullcalendar-timeline.min.js"></script>
    <script src="js/adminlte_js/fullcalendar-resource-common.min.js"></script>
    <script src="js/adminlte_js/fullcalendar-resource-timeline.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#faqBtn').click(function(e) {
          $('#faqtitle1').text('');
          $('#faqtitle2').text('Frequently Asked Questions');
          $('#faqsubtitle').text('');
        });
      });

      function removeNotifCount() {
        $('.notifCount').text('');
      }
    </script>
    @yield('script')
  </head>
  <body class="hold-transition skin-blue layout-top-nav fixed" style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;">

      <!--START OF HEADER-->
      <header class="main-header">
        <!--START OF NAVBAR-->
        @include('layouts.inc.nav')
        <!--END OF NAVBAR-->
      </header> <!--END OF HEADER-->

      <!--CONTENT WRAPPER-->
      @yield('content')
      <!--END OF CONTENT WRAPPER-->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <a href="mailto:academics@iacademy.edu.ph">academics@iacademy.edu.ph</a> | <a href="tel:028895555">(02) 889-5555</a> ext. 2000
        </div>
        <strong>Copyright &copy; 2019 <a href="http://www.iacademy.edu.ph">iACADEMY</a>.</strong> All rights reserved.
      </footer>
    </div><!--END OF WRAPPER-->
  </body>
</html>