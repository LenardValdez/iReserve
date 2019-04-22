<!--SIDEBAR-->
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="img/admin.jpg" class="img-circle" alt="User Image"> <!--USER IMAGE-->
      </div>
      <div class="pull-left info">
        <p>LERMA PANTORILLA</p>
        <a>Room Manager</a> <!--NAME AND ROLE OF USER-->
      </div>
    </div>

<!--
  FOLLOWING LINES ARE PLACEHOLDERS
-->
    <ul class="sidebar-menu" data-widget="tree">
      @if ($role = 0)
        <li class="header">MENU</li>
        <li class="active"><a href="studentdash.html"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="#"><a href="add.html"><i class="fa fa-building"></i> <span>Room Reservation</span></a></li>
        <li class="#"><a href="history.html"><i class="fa fa-history"></i> <span>Reservation History</span></a></li>
      @elseif($role = 1)
        <li class="header">MENU</li>
        <li class="active"><a href="studentdash.html"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="#"><a href="reserve.html"><i class="fa fa-building"></i> <span>Room Reservation</span></a></li>
      @else
        <li class="header">MENU</li>
        <li class="active"><a href="secdash.html"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="#"><a href="sechistory.html"><i class="fa fa-history"></i> <span>Reservation History</span></a></li>
      @endif
    </ul>
  </section>
</aside>
<!--END OF SIDEBAR-->