<!--NOTIFICATIONS-->
<li class="dropdown notifications-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <span class="label label-warning">1</span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">Notifications</li>
    <li>
      <ul class="menu">
        <li>
        <a href="{{ URL::route('Dashboard') }}">
            <i class="fa fa-clock-o text-orange"></i>
            @foreach (Auth::user()->notifications as $notification)
              <p>Your reservation has been
              @if ($notification->data['status'] == 1)
                  approved</p>
              @else
                  denied</p>
              @endif
              {{-- at {{$notification->updated_at->diffForHumans()}}  (para sa timestamp)--}}
            @endforeach
          </a>
        </li>
      </ul>
    </li>
  </ul>
</li>
<!--END OF NOTIFICATIONS-->