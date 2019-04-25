<!--SIDEBAR-->
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="img/admin.jpg" class="img-circle" alt="User Image"> <!--USER IMAGE-->
      </div>
      <div class="pull-left info">
      <p>{{{Auth::user()->name }}}</p>
        <a>Room Manager</a> <!--NAME AND ROLE OF USER-->
        @if (Auth()->user()->roles == 0)
          <a>Room Manager</a> <!--NAME AND ROLE OF USER-->
        @elseif(Auth()->user()->roles == 1)
          <a>User</a> <!--NAME AND ROLE OF USER-->
        @else
          <a>Security</a> <!--NAME AND ROLE OF USER-->
        @endif
      </div>
    </div>
<!--END OF SIDEBAR-->