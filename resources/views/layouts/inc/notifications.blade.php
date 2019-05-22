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
            @if (Auth::user()->roles == 1)
              @foreach (Auth::user()->unreadNotifications as $notification)
              <p>Your reservation has been
                @if ($notification->data['status'] == 1)
                    approved</p>
                @else
                    denied</p>
                @endif
              {{-- at {{$notification->updated_at->diffForHumans()}}  (para sa timestamp)--}}
              @endforeach
            @else
                @if (Auth::user()->unreadNotifications == null)
                  <p>There are no pending reservations</p>
                @else
                  {{-- <p>There are pending reservations</p> --}}
                  @foreach (Auth::user()->unreadNotifications as $notification)
                      {{$notification->data['user_id']}}
                  @endforeach
                @endif
            @endif
          </a>
        </li>
      </ul>
    </li>
  </ul>
</li>
<!--END OF NOTIFICATIONS-->