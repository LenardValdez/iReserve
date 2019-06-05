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
        columnDefs: [
          {
            "targets": [ 3,4 ],
            "visible": false,
            "searchable": false
          }
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
              }
          },
          /* download: 'open' */
          },
          {
          extend: 'csvHtml5',
          text: 'Export as CSV',
          exportOptions: {
              modifier: {
                  search: 'none'
              }
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
          <h1>Reservation History</h1>
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
          <!--NEW ROW-->

          <div class="row">
            <div class="col-md-12">
                @if(session('cancelledAlert'))
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  {{ session('cancelledAlert') }}
                </div>
                @endif
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Over-all History</h3>
                </div>

                <div class="box-body">
                  <!--NORMAL ROOM REQUEST INFORMATION MODAL-->
                  @foreach($reservations as $reservation)
                  <div class="modal fade" id="reqInfo{{$reservation->form_id}}">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Reservation Details</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <th>Date</th>
                                    <td>{{ \Carbon\Carbon::parse($reservation->created_at)->toDayDateTimeString() }}</td>
                                </tr>
                                <tr>
                                    <th>Room Number</th>
                                    <td>{{$reservation->room_id}}</td>
                                </tr>
                                <tr>
                                    <th>People Involved</th>
                                    <td>{{$reservation->users_involved}}</td>
                                </tr>
                                <tr>
                                    <th>Reservation Period</th>
                                    <td>{{$reservation->stime_res}} - {{$reservation->etime_res}}</td>
                                </tr>
                                <tr>
                                    <th>Purpose</th>
                                    <td>{{$reservation->purpose}}</td>
                                </tr>
                            </table>
                        </div>
                        @if (Auth()->user()->roles == 0 or Auth()->user()->roles == 1)
                        <div class="modal-footer">
                            @if(\Carbon\Carbon::parse($reservation->etime_res)->isPast() or $reservation->isCancelled==1 or $reservation->isApproved==2)
                              <button type="button" class="btn btn-danger" disabled>Cancel Reservation</button>
                            @else
                              <a type="button" class="btn btn-danger" href="{{ route('cancelrequest', $reservation->form_id) }}">Cancel Reservation</a>
                            @endif
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  @endforeach

                  <div class="table-responsive">
                    <table id="overallHistory" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th>Request ID</th>
                          <th>Student ID</th>
                          <th>Student Name</th>
                          <th>People Involved</th>
                          <th>Purpose</th>
                          <th>Room</th>
                          <th>Type</th>
                          <th>Submission Date</th>
                          <th>Response Date</th>
                          <th>Status</th>
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
                              <tr data-toggle="modal" data-target="#reqInfo{{$reservation->form_id}}">
                                <td>{{ sprintf("%07d", $reservation->form_id) }}</td>
                                <td>{{$reservation->user_id}}</td>
                                @foreach($users as $user)
                                  @if($user->user_id == $reservation->user_id)
                                    <td>{{$user->name}}</td>
                                  @endif
                                @endforeach
                                <td>@if($reservation->users_involved!=NULL){{$reservation->users_involved}} @else N/A @endif</td>
                                <td>{{$reservation->purpose}}</td>
                                <td>{{$reservation->room_id}}</td>
                                @foreach ($rooms as $room)
                                  @if ($room->room_id == $reservation->room_id) 
                                    @if ($room->isSpecial)
                                      <td><span class="label label-info">Special Room</span></td>
                                    @else
                                      <td><span class="label label-primary">Normal Room</span></td>
                                    @endif
                                  @endif
                                @endforeach
                                <td>{{ \Carbon\Carbon::parse($reservation->created_at)->toFormattedDateString() }}</td>
                                @if ($reservation->isApproved==0)
                                  <td>N/A</td> 
                                @else
                                  <td>{{ \Carbon\Carbon::parse($reservation->updated_at)->toFormattedDateString() }}</td>
                                @endif
                                @if($reservation->isCancelled == 1)
                                  <td><span class="label label-warning">Cancelled</span></td>
                                @elseif($reservation->isApproved == 1)
                                  <td><span class="label label-success">Approved</span></td>
                                @elseif($reservation->isApproved == 2)
                                  <td><span class="label label-danger">Rejected</span></td>
                                @else
                                  <td><span class="label label-info">Pending</span></td>
                                @endif
                              </tr>
                            @endforeach
                          @endif
                        @else
                        @if($reservations->isEmpty())
                          <tr>
                            <td colspan="10" class="text-center">Everything is good, no pending requests</td>
                          </tr>
                        @else
                          @foreach($reservations as $reservation)
                            <tr data-toggle="modal" data-target="#reqInfo{{$reservation->form_id}}">
                              <td>{{ sprintf("%07d", $reservation->form_id) }}</td>
                              <td>{{$reservation->user_id}}</td>
                              @foreach($users as $user)
                                @if($user->user_id == $reservation->user_id)
                                  <td>{{$user->name}}</td>
                                @endif
                              @endforeach
                              <td>@if($reservation->users_involved!=NULL){{$reservation->users_involved}} @else N/A @endif</td>
                              <td>{{$reservation->purpose}}</td>
                              <td>{{$reservation->room_id}}</td>
                              @foreach ($rooms as $room)
                                @if ($room->room_id == $reservation->room_id) 
                                  @if ($room->isSpecial)
                                    <td><span class="label label-info">Special Room</span></td>
                                  @else
                                    <td><span class="label label-primary">Normal Room</span></td>
                                  @endif
                                @endif
                              @endforeach
                              <td>{{ \Carbon\Carbon::parse($reservation->created_at)->toFormattedDateString() }}</td>
                              @if ($reservation->isApproved==0)
                                <td>N/A</td> 
                              @else
                                <td>{{ \Carbon\Carbon::parse($reservation->updated_at)->toFormattedDateString() }}</td>
                              @endif
                              @if($reservation->isCancelled == 1)
                              <td><span class="label label-warning">Cancelled</span></td>
                              @elseif($reservation->isApproved == 1)
                              <td><span class="label label-success">Approved</span></td>
                              @elseif($reservation->isApproved == 2)
                                <td><span class="label label-danger">Rejected</span></td>
                              @else
                                <td><span class="label label-info">Pending</span></td>
                              @endif
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
          </div><!--END OF ROW-->
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection
        