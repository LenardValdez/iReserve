<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iRESERVE</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/daterangepicker.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/skin-blue.min.css">
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <link rel="stylesheet" href="css/fullcalendar-scheduler.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <script src="js/adminlte_js/jquery.min.js"></script>
    <script src="js/adminlte_js/jquery-ui.min.js"></script>
    <script src="js/adminlte_js/moment.min.js"></script> <!--DATE FORMAT BEING USED BY DATERANGEPICKER-->
    <script src="js/adminlte_js/bootstrap.min.js"></script>
    <script src="js/adminlte_js/jquery.dataTables.min.js"></script> 
    <script src="js/adminlte_js/dataTables.bootstrap.min.js"></script>
    <script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
    <script src="js/adminlte_js/adminlte.min.js"></script>
    <script src="js/adminlte_js/daterangepicker.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
    <script src="js/adminlte_js/bootstrap-datepicker.min.js"></script> <!--JS FOR DATE AND TIME RANGE-->
    <script src="js/adminlte_js/select2.full.min.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
    <script src="js/adminlte_js/fullcalendar.min.js"></script> <!--CHANGE FORM DATE AND TIME FORMAT TO ISO8601 STRING USING moment().toISOString()-->
    <script src="js/adminlte_js/fullcalendar-scheduler.min.js"></script>
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
          academics@iacademy.edu.ph | (02) 889-5555 ext. 2000
        </div>
        <strong>Copyright &copy; 2019 <a href="http://www.iacademy.edu.ph">iACADEMY</a>.</strong> All rights reserved.
      </footer>
    </div><!--END OF WRAPPER-->
  </body>
</html>