<!--NOTIFICATIONS-->
<li class="dropdown notifications-menu">
    <a href="#" onclick="removeNotifCount()" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      @if (Auth::user()->unreadNotifications->count()!=0)
        <span class="notifCount label label-warning">{{Auth::user()->unreadNotifications->count()}}</span>
      @endif
    </a>
    <ul class="dropdown-menu">
      <li class="header">
        @if(Auth::user()->unreadNotifications->count()==1)
          You have 1 notification
        @else
          You have {{Auth::user()->unreadNotifications->count()}} notifications
        @endif
      </li>
      <li>
        <ul class="menu">
          @if (Auth::user()->roles == 1)
            @if (Auth::user()->unreadNotifications->count()==0)
              <li><a href="#"><i class="fa fa-check-circle-o text-green"></i> No new notifications.</a></li>
            @else
              @foreach (Auth::user()->unreadNotifications as $notification)
              <li>
                <a href="{{ route('readnotification', $notification->id) }}">
                  @if ($notification->data['cancel_status'] == 1)
                    Your reservation {{sprintf("%07d", $notification->data['form_id'])}} has been cancelled.
                    <small class="pull-right text-muted"><i class="fa fa-calendar-minus-o text-orange"></i> {{$notification->updated_at->diffForHumans()}}</small>
                  @else
                    @if ($notification->data['status'] == 1)
                      Your reservation {{sprintf("%07d", $notification->data['form_id'])}} has been approved.
                      <small class="pull-right text-muted"><i class="fa fa-calendar-check-o text-success"></i> {{$notification->updated_at->diffForHumans()}}</small>
                    @else
                      Your reservation {{sprintf("%07d", $notification->data['form_id'])}} has been denied.
                      <small class="pull-right text-muted"><i class="fa fa-calendar-times-o text-danger"></i> {{$notification->updated_at->diffForHumans()}}</small>
                    @endif
                  @endif
                </a>
              </li>
              @endforeach
            @endif
          @else
              @if (Auth::user()->unreadNotifications->count()==0)
                <li><a href="#"><i class="fa fa-check-circle-o text-green"></i> No new notifications.</a></li>
              @else
                  @foreach (Auth::user()->unreadNotifications as $notification)
                  <li>
                    <a href="{{ route('readnotification', $notification->id) }}">
                      Student {{$notification->data['user_id']}} has a new reservation.
                      <small class="pull-right text-muted"><i class="fa fa-clock-o text-orange"></i> {{$notification->updated_at->diffForHumans()}}</small>
                    </a>
                  </li>
                  @endforeach
              @endif
          @endif
        </ul>
      </li>
      @if (Auth::user()->unreadNotifications->count()>1)
      <li class="footer">
          <a href="{{URL::route('readallnotifs')}}">Clear all</a>
      </li>
      @endif
    </ul>
  </li>
  <!--END OF NOTIFICATIONS-->