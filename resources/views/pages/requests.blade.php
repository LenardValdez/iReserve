@extends('layouts.app')

@section('script')
  <script src="js/adminlte_js/jquery.min.js"></script>
  <script src="js/adminlte_js/jquery-ui.min.js"></script>
  <script src="js/adminlte_js/bootstrap.min.js"></script>
  <script src="js/adminlte_js/moment.min.js"></script> <!--DATE FORMAT BEING USED BY DATERANGEPICKER-->
  <script src="js/adminlte_js/daterangepicker.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
  <script src="js/adminlte_js/bootstrap-datepicker.min.js"></script> <!--JS FOR DATE AND TIME RANGE-->
  <script src="js/adminlte_js/dataTables.bootstrap.min.js"></script>
  <script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
  <script src="js/adminlte_js/adminlte.min.js"></script>
@endsection

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
  <ul class="nav navbar-nav">
    @if (Auth()->user()->roles == 0)
      <li class="active"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
      <li class="#"><a href={{URL::route('History')}}>Reservation History</a></li>
    @elseif (Auth()->user()->roles == 1)
      <li class="active"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
    @endif
  </ul>
</div>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          </ol>
        </section>

        <!--ACTUAL CONTENT-->
        <section class="content container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Pending Requests</h3>
                </div>

              <div class="box-body">
                @foreach($pendingforms as $form)
                <!--SPECIAL ROOM REQUEST INFORMATION MODAL-->
                <div class="modal fade" id="specialInfo{{$form->form_id}}">
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
                                <td>{{ \Carbon\Carbon::parse($form->created_at)->toDayDateTimeString() }}</td>
                            </tr>
                            <tr>
                                <th>Room Number</th>
                                <td>{{$form->room_id}}</td>
                            </tr>
                            <tr>
                                <th>People Involved</th>
                                <td>{{$form->users_involved}}</td>
                            </tr>
                            <tr>
                                <th>Reservation Period</th>
                                <td>{{ \Carbon\Carbon::parse($form->stime_res)->format('M d, Y h:m A')}} - {{ \Carbon\Carbon::parse($form->etime_res)->format('M d, Y h:m A')}}</td>
                            </tr>
                            <tr>
                                <th>Purpose</th>
                                <td>{{$form->purpose}}</td>
                            </tr>
                        </table>
                      </div>
                      <div class="modal-footer">
                          <a type="button" href="{{ route('rejectrequest', $form->form_id) }}" class="btn btn-danger pull-left" data-target="#rejectModal" data-dismiss="modal" data-toggle="modal">Reject</a>
                          <a type="button" href="{{ route('approverequest', $form->form_id) }}" class="btn btn-success" data-target="#approveModal" data-dismiss="modal" data-toggle="modal">Approve</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                <!--REQUEST APPROVAL CONFIRMATION MODAL-->
                <div class="modal fade" id="approveModal">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Reservation Approved</h4>
                      </div>
                      <div class="modal-body">
                        <h4>The request has been approved and added to the scheduler.</h4>
                      </div>
                    </div>
                  </div>
                </div>

                <!--REQUEST REJECTION CONFIRMATION MODAL-->
                <div class="modal fade" id="rejectModal">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Reservation Rejected</h4>
                      </div>
                      <div class="modal-body">
                        <h4>The request has been rejected.</h4>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                      <tr>
                        <th>Request ID</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Submission Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($pendingforms->isEmpty())
                        <tr>
                          <td colspan="4" class="text-center">No pending requests</td>
                        </tr>
                      @else
                        @foreach($pendingforms as $form)
                        <tr data-toggle="modal" data-target="#specialInfo{{$form->form_id}}">
                          <td>{{ sprintf("%07d", $form->form_id) }}</td>
                          <td>{{$form->room_id}}</td>
                          <td><span class="label label-info">Special Room</span></td>
                          <td>{{ \Carbon\Carbon::parse($form->created_at)->toFormattedDateString() }}</td>
                        </tr>
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div><!--END OF BOX-BODY-->

                <div class="box-footer clearfix">
                  <a href={{URL::route('History')}} class="btn btn-sm btn-default btn-flat pull-right">View Full History</a>
                </div>
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN--> 
          </div><!--END OF ROW-->
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection