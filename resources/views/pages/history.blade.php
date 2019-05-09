@extends('layouts.app')

@section('script')
  <script src="js/adminlte_js/jquery.min.js"></script>
  <script src="js/adminlte_js/bootstrap.min.js"></script>
  <script src="js/adminlte_js/jquery.dataTables.min.js"></script>
  <script src="js/adminlte_js/dataTables.bootstrap.min.js"></script>
  <script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
  <script src="js/adminlte_js/adminlte.min.js"></script>
  <script>
    $(function () {
      $('#overallHistory').DataTable()
    })
  </script>
@endsection

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
  <ul class="nav navbar-nav">
    @if (Auth()->user()->roles == 0)
      <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
      <li class="active"><a href={{URL::route('History')}}>Reservation History</a></li>
    @elseif (Auth()->user()->roles == 1)
      <li class="active"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
    @else
      <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="active"><a href={{URL::route('History')}}>Reservation History</a></li>
    @endif
  </ul>      
</div>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
          <h1>Reservation History</h1>
          <ol class="breadcrumb">
            <li><a href="admindash.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reservation History</li>
          </ol>
        </section>

        <!--ACTUAL CONTENT-->
        <section class="content container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Over-all History</h3>
                </div>

                <div class="box-body">
                  <!--NORMAL ROOM REQUEST INFORMATION MODAL-->
                  <div class="modal fade" id="reqInfo">
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
                          <h4><b>Room Number: </b>901</h4>
                          <h4><b>People Involved: </b>Nicole Kaye Bilon, Miqaela Nicole Banguilan</h4>
                          <h4><b>Reservation Period: </b>March 24, 2019 02:00PM - March 24, 2019 06:00PM</h4>
                          <h4><b>Reason: </b>SEAL Meeting</h4>
                        </div>
                        @if (Auth()->user()->roles == 0 or Auth()->user()->roles == 1)
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-target="#cancelRequestModal" data-dismiss="modal" data-toggle="modal">Cancel Reservation</button>
                        </div>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!--CANCELLATION MODAL-->
                  <div class="modal fade" id="cancelRequestModal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Override Reservation</h4>
                        </div>
                        <div class="modal-body">
                          <h4>Are you sure you want to cancel this request?</h4>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                          <button type="button" class="btn btn-success" data-target="#successCancelModal" data-dismiss="modal" data-toggle="modal">Yes</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!--CANCELLATION SUCCESS MODAL-->
                  <div class="modal fade" id="successCancelModal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Request Cancelled</h4>
                        </div>
                        <div class="modal-body">
                          <h4>The request has been successfully cancelled.</h4>
                        </div>
                      </div>
                    </div>
                  </div>

                  <table id="overallHistory" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Request ID</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Submission Date</th>
                        <th>Response Date</th>
                      </tr>
                    </thead> 

                    <tbody>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000016</a></td>
                        <td>901</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>May 1, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000015</a></td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Pending</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 19, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000014</a></td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Pending</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 12, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000013</a></td>
                        <td>914</td>
                        <td><span class="label label-danger">Rejected</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>April 11, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000012</a></td>
                        <td>1006</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 15, 2019</td>
                        <td>March 15, 2019</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000011</a></td>
                        <td>901</td>
                        <td><span class="label label-danger">Rejected</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>March 14, 2019</td>
                        <td>March 15, 2019</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000010</a></td>
                        <td>603</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>March 12, 2019</td>
                        <td>March 12, 2019</td>
                      </tr>

                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000009</a></td>
                        <td>904</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>March 11, 2019</td>
                        <td>March 12, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000008</a></td>
                        <td>BBCOURT</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>March 2, 2019</td>
                        <td>March 2, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000007</a></td>
                        <td>1006 (CL2)</td>
                        <td><span class="label label-danger">Rejected</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>February 27, 2019</td>
                        <td>February 28, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000006</a></td>
                        <td>912</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>February 20, 2019</td>
                        <td>February 20, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000005</a></td>
                        <td>801</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>January 28, 2019</td>
                        <td>January 29, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000004</a></td>
                        <td>901</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>January 24, 2019</td>
                        <td>January 25, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000003</a></td>
                        <td>801</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>January 20, 2019</td>
                        <td>January 20, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000002</a></td>
                        <td>601</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>January 19, 2019</td>
                        <td>January 19, 2019</td>
                      </tr>
                      <tr>
                        <td><a data-toggle="modal" href="#reqInfo">000001</a></td>
                        <td>910</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>January 5, 2019</td>
                        <td>January 7, 2019</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!--END OF BOX-BODY-->
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN-->
          </div><!--END FO ROW-->
          <!--NEW ROW-->
          @if (Auth()->user()->roles == 1)
          <div class="row">
              <div class="col-md-12">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title">Frequently Asked Questions</h3>
                  </div>
  
                  <div class="box-body">
                    <div class="box-group" id="faq">
                      <!-- .panel class is declared so that bootstrap.js collapse plugin detects it -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#faq" href="#collapseOne">
                              How to Reserve A Room
                            </a>
                          </h4>
                        </div>
  
                        <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                          </div>
                        </div>
                      </div>
  
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#faq" href="#collapseTwo">
                              Room Reservation Policy
                            </a>
                          </h4>
                        </div>
  
                        <div id="collapseTwo" class="panel-collapse collapse">
                          <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                          </div>
                        </div>
                      </div>
  
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#faq" href="#collapseThree">
                              Contact Information
                            </a>
                          </h4>
                        </div>
  
                        <div id="collapseThree" class="panel-collapse collapse">
                          <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!--END OF BOX BODY-->
                </div><!--END OF CONTENT BOX-->
              </div><!--END OF COLUMN-->
            </div><!--END OF ROW-->
          @endif
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection
        