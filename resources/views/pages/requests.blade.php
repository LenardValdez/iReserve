@extends('layouts.app')

@section('script')
  @if(Auth()->user()->roles == 0)
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

        @if (Auth()->user()->roles == 0)
          @include('layouts.inc.faq')
        @endif
        
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
              
              @if(session('approvedAlert'))
              <div class="alert alert-success">
                {{ session('approvedAlert') }}
              </div>
              @endif

              @if(session('rejectedAlert'))
              <div class="alert alert-danger">
                {{ session('rejectedAlert') }}
              </div>
              @endif

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
                          <a type="button" href="{{ route('rejectrequest', $form->form_id) }}" class="btn btn-danger pull-left">Reject</a>
                          <a type="button" href="{{ route('approverequest', $form->form_id) }}" class="btn btn-success">Approve</a>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

                <div class="table-responsive">
                  <table class="table no-margin table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Request ID</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Room Number</th>
                        <th>Date Submitted</th>
                        <th>Room Type</th>
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
                          <td>{{$form->user_id}}</td>
                          @foreach($users as $user)
                            @if($user->user_id == $form->user_id)
                            <td>{{$user->name}}</td>
                            @endif
                          @endforeach
                          <td>{{$form->room_id}}</td>
                          <td>{{ \Carbon\Carbon::parse($form->created_at)->toFormattedDateString() }}</td>
                          <td><span class="label label-info">Special Room</span></td>
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
          @if (Auth()->user()->roles == 0)
            <div style="position: absolute; bottom:50px; right:10px;">
              <div style="position:relative; top:0; left:0;">
                  <a class="btn btn-app" id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal"><i class="fa fa-question-circle-o"></i>FAQ</a>
              </div>
            </div>
          @endif
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection