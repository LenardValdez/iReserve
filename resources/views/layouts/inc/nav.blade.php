<!--START OF NAVBAR-->
<nav class="navbar navbar-static-top" role="navigation">
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

      @if (Auth()->user()->roles == 0 or Auth()->user()->roles == 1 )
        <!--NOTIFICATIONS-->
        @include('layouts.inc.notifications')
        <!--END OF NOTIFICATIONS-->
      @endif

      <!--USER INFO+LOGOUT-->
      @include('layouts.inc.info')
      <!--END OF USER INFO+LOGOUT-->
    </ul>
  </div>
</nav> <!--END OF NAVBAR-->