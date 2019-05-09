<!--USER INFO+LOGOUT-->
<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="img/admin.jpg" class="user-image" alt="User Image"> <!--USER IMAGE-->
    <span class="hidden-xs">{{{Auth::user()->name }}}</span> <!--NAME OF USER-->
  </a>
  <ul class="dropdown-menu">
    <li class="user-header">
      <img src="img/admin.jpg" class="img-circle" alt="User Image"> <!--USER IMAGE-->
      <p>
        {{{Auth::user()->name }}}
        <small>
          @if ($role == 0)
          Room Manager<!--NAME AND ROLE OF USER-->
          @elseif($role == 1)
          User<!--NAME AND ROLE OF USER-->
          @else
          Security<!--NAME AND ROLE OF USER-->
          @endif
        </small> <!--NAME AND ROLE OF USER-->
      </p>
    </li>

    <li class="user-footer">
      @if ($role == 0 or $role == 1 )
        <div class="pull-left">
          <a href="http://isims.iacademy.edu.ph" target="_blank" class="btn btn-default btn-flat">iSIMS</a>
        </div>
      @endif
      <div class="pull-right">
        <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </li>
  </ul>
</li> <!--END OF USER INFO+LOGOUT-->