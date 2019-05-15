@extends('layouts.app')

@section('script')
  <script src="js/adminlte_js/jquery.min.js"></script>
  <script src="js/adminlte_js/bootstrap.min.js"></script>
  <script src="js/adminlte_js/jquery.dataTables.min.js"></script>
  <script src="js/adminlte_js/dataTables.bootstrap.min.js"></script>
  <script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
  <script src="js/adminlte_js/adminlte.min.js"></script>
  <script>
  
  <script>    
    $(function () {
      $('#overallHistory').DataTable()
    })
  </script>

  @if(Auth()->user()->roles == 1)
    <script>
      $(window).on('load',function(){
        if (!sessionStorage.getItem('shown-modal')){
          $('#welcomeFAQModal').modal('show');
          $('#faqBtn').css('z-index', '5000');
          sessionStorage.setItem('shown-modal', 'true');
        }
      });

      $(document).ready(function() {
        $('#faqBtn').click(function(e) {
          $('#faqtitle1').text('');
          $('#faqtitle2').text('Frequently Asked Questions');
          $('#faqsubtitle').text('');
        });
      });
    </script>
  @endif
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
      <li class="#"><a href={{ URL::route('Dashboard') }}>Room Overview</a></li>
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
            @if (Auth()->user()->roles == 0)
            <li><a href={{ URL::route('Dashboard') }}><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Reservation History</li>
            @elseif (Auth()->user()->roles == 2)
            <li><a href={{ URL::route('Dashboard') }}><i class="fa fa-building"></i> Room Overview</a></li>
            <li class="active">Reservation History</li>
            @else 
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            @endif
          </ol>
        </section>

        <!--ACTUAL CONTENT-->
        <section class="content container-fluid">
          <!--NEW ROW-->
          <div class="modal fade" id="welcomeFAQModal">
            <div class="modal-dialog" role="document" style="top: 15%;">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h2 class="modal-title text-center" id="faqtitle1">Welcome to iReserve!</h2>
                  <h4 class="modal-title text-center" id="faqtitle2"></h4>
                </div>
                <div class="modal-body">
                  <h4 id="faqsubtitle">Frequently Asked Questions</h4>
                    <div class="box-group" id="faq">
                      <!-- .panel class is declared so that bootstrap.js collapse plugin detects it -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseOne">
                          <h4 class="box-title text-info">How to Reserve A Room</h4>
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
                        <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseTwo">
                          <h4 class="box-title text-info">Room Reservation Policy</h4>
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
                        <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseThree">
                          <h4 class="box-title text-info">Contact Information</h4>
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
                </div>
              </div>
            </div>
          </div>

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
                            <table class="table">
                                <tr>
                                    <th>Date</th>
                                    <td>March 20, 2019</td>
                                </tr>
                                <tr>
                                    <th>Room Number</th>
                                    <td>1005 (CL1)</td>
                                </tr>
                                <tr>
                                    <th>People Involved</th>
                                    <td>Nicole Kaye Bilon, Miqaela Nicole Banguilan</td>
                                </tr>
                                <tr>
                                    <th>Reservation Period</th>
                                    <td>March 24, 2019 02:00PM - March 24, 2019 06:00PM</td>
                                </tr>
                                <tr>
                                    <th>Purpose</th>
                                    <td>SEAL Meeting</td>
                                </tr>
                            </table>
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

                  <table id="overallHistory" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Request ID</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Room</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Submission Date</th>
                        <th>Response Date</th>
                      </tr>
                    </thead> 

                    <tbody>
                      <tr data-toggle="modal" data-target="#reqInfo">
                        <td>000016</td>
                        <td>201701054</td>
                        <td>Lenard Valdez</td>
                        <td>901</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td><span class="label label-primary">Normal Room</span></td>
                        <td>May 1, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr data-toggle="modal" data-target="#reqInfo">
                        <td>000015</td>
                        <td>201701054</td>
                        <td>Lenard Valdez</td>
                        <td>1007 (MMA Lab)</td>
                        <td><span class="label label-info">Pending</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 19, 2019</td>
                        <td>N/A</td>
                      </tr>

                      <tr data-toggle="modal" data-target="#reqInfo">
                        <td>000014</td>
                        <td>201701054</td>
                        <td>Lenard Valdez</td>
                        <td>1005 (CL1)</td>
                        <td><span class="label label-info">Pending</span></td>
                        <td><span class="label label-info">Special Room</span></td>
                        <td>April 12, 2019</td>
                        <td>N/A</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!--END OF BOX-BODY-->
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN-->
          </div><!--END OF ROW-->

          @if (Auth()->user()->roles == 1)
          <a class="btn btn-app" id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal" style="bottom: 8%; right: 2%; position: fixed;"><i class="fa fa-question-circle-o"></i>FAQ</a>
          @endif
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection
        