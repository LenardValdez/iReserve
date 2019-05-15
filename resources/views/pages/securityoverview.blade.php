@extends('layouts.app')

@section('script')
  <script>
    $(function () {
      $('#calendar').fullCalendar({
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        themeSystem: 'bootstrap3',
        header: {
            left: 'today prev,next',
            center: 'title',
            right: 'timelineDay,timelineWeek,timelineMonth'
        },
        businessHours: {
            dow: [ 1, 2, 3, 4 ,5, 6],

            start: '07:30',
            end: '21:00',
        },
        height: '800',
        defaultView: 'timelineDay',
        resourceLabelText: 'Rooms',
        resourceGroupField: 'floorNum',
        resources: [
            @foreach($rooms as $room)
            { id: '{{ $room->room_id }}', floorNum: '{{ $room->room_desc }}', title: '{{ $room->room_id }}' },
            @endforeach
        ],
        events: [
            @foreach($users as $user)
                @foreach($forms as $form)
                    { 
                    @if($user->user_id == $form->user_id)
                    title: '{{ sprintf("%07d", $form->form_id) }} | {{ $user->name }}', 
                    resourceId: '{{ $form->room_id }}', 
                    @endif
                    start: moment('{{ $form->stime_res }}').format(), 
                    end: moment('{{ $form->etime_res }}').format()
                    },
                @endforeach
            @endforeach
        ]
        });

        calendar.render();
      });
    });
  </script>
@endsection

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href={{ URL::route('Dashboard') }}>Room Overview</a></li>
      <li><a href={{URL::route('History')}}>Reservation History</a></li>
    </ul>      
</div>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
    <!--PAGE TITLE AND BREADCRUMB-->
    <section class="content-header">
      <h1>Room Overview</h1>
      <ol class="breadcrumb">
        <li class="active"><i class="fa fa-building"></i> Room Overview</li>
      </ol>
    </section>

    <!--ACTUAL CONTENT-->
    <section class="content container-fluid">
      <div class="row">
        <div class = "col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Room Availability</h3>
            </div>
            <div class="box-body">
              <div id="calendar"></div>
            </div>
          </div> <!--END OF CONTENT BOX-->
        </div> <!--END OF COLUMN-->
      </div> <!--END OF ROW-->
    </section><!--END OF ACTUAL CONTENT-->
  </div><!--END OF CONTENT-WRAPPER-->
@endsection