<!--NOTIFICATIONS-->
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
    @if (Auth::user()->unreadNotifications->count()==0)
    <span></span>
    @else
      <span class="label label-warning">{{Auth::user()->unreadNotifications->count()}}</span>
    @endif
    </a>
    <ul class="dropdown-menu">
      <li class="header">Notifications</li>
      <li>
        <ul class="menu">
          @if (Auth::user()->roles == 1)
            @if (Auth::user()->unreadNotifications->count()==0)
              <li><a href="#">No new notifications.</a></li>
            @else
              @foreach (Auth::user()->unreadNotifications as $notification)
              <li>
              <a href="{{ route('readnotification', $notification->id) }}">
                  <i class="fa fa-clock-o text-orange"></i> Your reservation {{sprintf("%07d", $notification->data['form_id'])}} has been
                      @if ($notification->data['status'] == 1)
                          approved.
                      @else
                          denied.
                      @endif
                  {{-- at {{$notification->updated_at->diffForHumans()}}  (para sa timestamp)--}}
              </a>
              </li>
              @endforeach
            @endif
          @else
              @if (Auth::user()->unreadNotifications->count()==0)
                <li><a href="#">No new notifications.</a></li>
              @else
                  @foreach (Auth::user()->unreadNotifications as $notification)
                  <li>
                  <a href="{{ route('readnotification', $notification->id) }}">
                      <i class="fa fa-clock-o text-orange"></i> Student {{$notification->data['user_id']}} has a new reservation
                  </a>
                  </li>
                  @endforeach
              @endif
          @endif
        </ul>
      </li>
    </ul>
  </li>
  <!--END OF NOTIFICATIONS-->