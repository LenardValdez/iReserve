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
    <link rel="stylesheet" href="css/daterangepicker.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/AdminLTE.min.css">
    <link rel="stylesheet" href="css/skin-blue.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    @if (Auth::user()->role == 0)
        @yield('AdminStyle')
    @endif
    
    @yield('script')
  </head>

  <body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">

      <!--START OF HEADER-->
      <header class="main-header">
        <a href="admindash.html" class="logo">
          <span class="logo-mini"><img src="img/iacademy_shield.png" style="width: 25px;" class="img-circle" alt="iACADEMY"></span>
          <span class="logo-md"><img src="img/iacademy_shield.png" style="width: 25px;" class="img-circle" alt="iACADEMY"> iRESERVE</span>
        </a>

        <!--START OF NAVBAR-->
        @include('inc.nav')
        </nav> <!--END OF NAVBAR-->
      </header> <!--END OF HEADER-->

      <!--SIDEBAR-->
      @include('inc.sidebar')
      <!--END OF SIDEBAR-->

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