@extends('layouts.test')

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
                <!--SPECIAL ROOM REQUEST INFORMATION MODAL-->
                <div class="modal fade" id="specialInfo">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Reservation Details</h4>
                      </div>
                      <div class="modal-body">
                        <h4><b>Date: </b>March 20, 2019</h4>
                          <h4><b>Room Number: </b>1005 (CL1)</h4>
                          <h4><b>People Involved: </b>Nicole Kaye Bilon, Miqaela Nicole Banguilan</h4>
                          <h4><b>Reservation Period: </b>March 24, 2019 02:00PM - March 24, 2019 06:00PM</h4>
                          <h4><b>Reason: </b>SEAL Meeting</h4>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-target="#rejectModal" data-dismiss="modal" data-toggle="modal">Reject</button>
                        <button type="button" class="btn btn-success" data-target="#approveModal" data-dismiss="modal" data-toggle="modal">Approve</button>
                      </div>
                    </div>
                  </div>
                </div>

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
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000016</a></td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>May 1, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000015</a></td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 19, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000014</a></td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 12, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000013</a></td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 1, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000012</a></td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 21, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000011</a></td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 19, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000010</a></td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 13, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#specialInfo">000009</a></td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 11, 2019</td>
                      </tr>
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