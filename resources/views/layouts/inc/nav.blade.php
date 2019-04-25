<!--START OF NAVBAR-->
<nav class="navbar navbar-static-top" role="navigation">
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

      <!--NOTIFICATIONS-->
      @include('layouts.inc.notifications')
      </li>
      <!--END OF NOTIFICATIONS-->

      <!--USER INFO+LOGOUT-->
      @include('layouts.inc.info')
      </li> <!--END OF USER INFO+LOGOUT-->
    </ul>
  </div>
</nav> <!--END OF NAVBAR-->