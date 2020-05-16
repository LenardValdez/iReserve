@extends('layouts.app')

@section('script')

@if (Auth()->User()->roles == 1)
  <script>
    $(window).on('load',function(){
    if (!sessionStorage.getItem('shown-modal')){
      $('#welcomeFAQModal').modal('show');
      sessionStorage.setItem('shown-modal', 'true');
      }
    });
  </script>
@endif

  <script>    
    $(document).ready(function () {
      $('#overallHistory').DataTable({
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        columnDefs: [
          {
            @if(Auth()->user()->roles==0)
              "targets": [ 3,4 ],
            @elseif(Auth()->user()->roles==1)
              "targets": [ 3,4,6,8 ],
            @else
              "targets": [ 3,4,8 ],
            @endif
            "visible": false,
            "searchable": false
          },
          { 
            "orderable": false, 
            "targets": 10 
          },
          { width: 70, targets: 10 },
        ],
        lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
          'pageLength',
          {
          extend: 'pdfHtml5',
          text: 'Export as PDF',
          orientation: 'landscape',
          exportOptions: {
              modifier: {
                  selected: null
              },
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
          },
          download: 'open'
          },
          {
          extend: 'csvHtml5',
          text: 'Export as CSV',
          exportOptions: {
              modifier: {
                  search: 'none'
              },
              columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
            }
          }
        ],
        select: true
      });
    });
  </script>
@endsection

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
  <ul class="nav navbar-nav">
    @if (Auth()->user()->roles == 0)
      <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Management</a></li>
      <li class="active"><a href={{URL::route('History')}}>Reservation History</a></li>
      <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
    @elseif (Auth()->user()->roles == 1)
      <li class="active"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
      <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
    @else
      <li class="#"><a href={{ URL::route('Dashboard') }}>Room Overview</a></li>
      <li class="active"><a href={{URL::route('History')}}>Reservation History</a></li>
      <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
    @endif
  </ul>      
</div>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
        @include('layouts.inc.faq')
        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
          @if(Auth()->user()->roles == 2)
            <h1>Reservation History</h1>
          @else
            <h1>Dashboard</h1>
          @endif
          <ol class="breadcrumb">
            @if (Auth()->user()->roles == 0)
            <li><a href={{ URL::route('Dashboard') }}><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reservation History</li>
            @elseif(Auth()->user()->roles == 2)
            <li><a href={{ URL::route('Dashboard') }}><i class="fa fa-building"></i> Room Overview</a></li>
            <li class="active">Reservation History</li>
            @else 
            <li class="active"><i class="fa fa-building"></i> Room Overview</a></li>
            <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
            @endif
          </ol>
        </section>

        <!--ACTUAL CONTENT-->
        <section class="content container-fluid">
          <div class="row">
            @if(Auth()->User()->roles == 0)
            <div class="col-md-12">
            @else
            <div class="col-lg-4">
              <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-aqua-active">
                  <div class="widget-user-image">
                    <img class="img-circle" src="img/user.png" alt="User Avatar">
                  </div>
                  <h3 class="widget-user-username">{{Auth()->user()->name}}</h3>
                  <h5 class="widget-user-desc">{{Auth()->user()->user_id}}</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a>Total Reservations Submitted <span class="pull-right badge bg-blue">{{ $studentReservations->count() }}</span></a></li>
                    <li><a>Reservations Approved <span class="pull-right badge bg-green">{{ $approvedCount }}</span></a></li>
                    <li><a>Reservations Cancelled <span class="pull-right badge bg-red">{{ $cancelledCount }}</span></a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
              <div class="col-lg-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>{{$upcomingReservations->count()}}</h3>
                    <p><b>Confirmed</b><br>This Week</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-check-square-o"></i>
                  </div>
                  <a href="#" class="small-box-footer">
                  </a>
                </div>
              </div>
              <div class="col-lg-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>{{$pendingCount}}</h3>
                    <p><b>Pending</b><br>Awaiting Approval</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-hourglass-half"></i>
                  </div>
                  <a href="#" class="small-box-footer">
                  </a>
                </div>
              </div>
              </div>

              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Upcoming Reservations</h3>
                </div>

                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Reservation Period</th>
                          <th>Room</th>
                          @if(Auth()->user()->roles == 2)
                          <th>Name</th>
                          @endif
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($upcomingReservations->isEmpty())
                          <tr>
                            <td colspan="6" class="text-center">No upcoming reservations to monitor so far!</td>
                          </tr>
                        @else
                          @foreach($upcomingReservations as $form)
                          @if(!Carbon::parse($form->etime_res)->isPast())
                          <tr data-toggle="modal" data-target="#reqInfo{{$form->form_id}}" style="cursor: pointer">
                            <td>{{ Carbon::parse($form->stime_res)->format('M d, Y h:i A') }} - {{ Carbon::parse($form->etime_res)->format('M d, Y h:i A') }}</td>
                            <td>{{$form->room_id}}</td>
                            @if(Auth()->user()->roles == 2)
                            <td>{{$form->user->name}}</td>
                            @endif
                            <td>
                              @if(Carbon::parse($form->etime_res)->isFuture())
                                @if(Carbon::parse($form->stime_res)->isPast())
                                  <span class="label label-success">Ongoing</span>
                                @else
                                  <span class="label label-warning">Upcoming</span>
                                @endif
                              @endif
                            </td>
                          </tr>
                          @endif
                          @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div><!--END OF BOX-BODY-->
                <div class="box-footer clearfix">
                </div>
              </div><!--END OF CONTENT BOX-->
            </div>
            <div class="col-md-8">
            @endif
                @include('layouts.alerts.successAlert', ['redirectMessageName' => 'cancelledAlert'])
                @if(Auth()->User()->roles == 1)
                  @include('layouts.modals.infoModal', ['forms' => $studentReservations, 'isOverall' => false, 'isSchedule' => false, 'isApproval' => false])
                  @include('layouts.modals.infoModal', ['forms' => $upcomingReservations, 'isOverall' => false, 'isSchedule' => false, 'isApproval' => false])
                @else
                  @include('layouts.modals.infoModal', ['forms' => $reservations, 'isOverall' => true, 'isSchedule' => false, 'isApproval' => false])
                @endif
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Over-all History</h3>
                </div>
                <div class="box-body">
                  <div class="table-responsive">
                    <table id="overallHistory" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Request ID</th>
                          @if(Auth()->User()->roles == 1)
                          <th>Start Date and Time</th>
                          <th>End Date and Time</th>
                          @else
                          <th>ID</th>
                          <th>Name</th>
                          @endif
                          <th>People Involved</th>
                          <th>Purpose</th>
                          <th>Room</th>
                          <th>Type</th>
                          <th>Submission Date</th>
                          <th>Response Date</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead> 

                      <tbody>
                        @if(Auth()->User()->roles == 1)
                          @if($studentReservations->isEmpty())
                            <tr>
                              <td colspan="10" class="text-center">Oops! Looks like you haven't submitted any requests yet.</td>
                            </tr>
                          @else
                            @foreach($studentReservations as $reservation)
                              <tr>
                                <td>{{ sprintf("%07d", $reservation->form_id) }}</td>
                                <td><time datetime="{{ $reservation->stime_res }}">{{ Carbon::parse($reservation->stime_res)->format('M d, Y h:i A') }}</time></td>
                                <td><time datetime="{{ $reservation->etime_res }}">{{ Carbon::parse($reservation->etime_res)->format('M d, Y h:i A') }}</time></td>
                                <td>@if($reservation->users_involved!=NULL){{$reservation->users_involved}} @else N/A @endif</td>
                                <td>{{$reservation->purpose}}</td>
                                <td>{{$reservation->room_id}}</td>
                                  @if ($reservation->room->isSpecial)
                                    <td><span class="label label-info">Special Room</span></td>
                                  @else
                                    <td><span class="label label-primary">Normal Room</span></td>
                                  @endif
                                <td>{{ Carbon::parse($reservation->created_at)->toFormattedDateString() }}</td>
                                @if ($reservation->isApproved==0)
                                  <td>N/A</td> 
                                @else
                                  <td>{{ Carbon::parse($reservation->updated_at)->toFormattedDateString() }}</td>
                                @endif
                                @if($reservation->isCancelled == 1)
                                  <td><span class="label label-warning">Cancelled</span></td>
                                @else
                                  @if($reservation->isApproved == 1)
                                    <td><span class="label label-success">Approved</span></td>
                                  @elseif($reservation->isApproved == 2)
                                    <td><span class="label label-danger">Rejected</span></td>
                                  @else
                                    <td><span class="label label-info">Pending</span></td>
                                  @endif
                                @endif
                                <td class="text-center"><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#reqInfo{{$reservation->form_id}}">See More</button></td>
                              </tr>
                            @endforeach
                          @endif
                        @else
                        @if($reservations->isEmpty())
                          <tr>
                            <td colspan="10" class="text-center">Everything is good, no pending requests!</td>
                          </tr>
                        @else
                          @foreach($reservations as $reservation)
                            <tr>
                              <td>{{ sprintf("%07d", $reservation->form_id) }}</td>
                              <td>{{$reservation->user_id}}</td>
                              <td>{{$reservation->user->name}}</td>
                              <td>@if($reservation->users_involved!=NULL){{$reservation->users_involved}} @else N/A @endif</td>
                              <td>{{$reservation->purpose}}</td>
                              <td>{{$reservation->room_id}}</td>
                              @if ($reservation->room->isSpecial)
                                <td><span class="label label-info">Special Room</span></td>
                              @else
                                <td><span class="label label-primary">Normal Room</span></td>
                              @endif
                              <td>{{ Carbon::parse($reservation->created_at)->toFormattedDateString() }}</td>
                              @if ($reservation->isApproved==0)
                                <td>N/A</td> 
                              @else
                                <td>{{ Carbon::parse($reservation->updated_at)->toFormattedDateString() }}</td>
                              @endif
                              @if($reservation->isCancelled == 1)
                              <td><span class="label label-warning">Cancelled</span></td>
                              @else
                                @if($reservation->isApproved == 1)
                                <td><span class="label label-success">Approved</span></td>
                                @elseif($reservation->isApproved == 2)
                                  <td><span class="label label-danger">Rejected</span></td>
                                @else
                                  <td><span class="label label-info">Pending</span></td>
                                @endif
                              @endif
                              <td class="text-center"><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#reqInfo{{$reservation->form_id}}">See More</button></td>
                            </tr>
                          @endforeach
                        @endif
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div><!--END OF BOX-BODY-->
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN-->
          </div>
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection
        