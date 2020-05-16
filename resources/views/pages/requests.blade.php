@extends('layouts.app')

@section('script')
  <script>
    $(window).on('load',function(){
    if (!sessionStorage.getItem('shown-modal')){
      $('#welcomeFAQModal').modal('show');
      sessionStorage.setItem('shown-modal', 'true');
      }
    });


    window.onload = function() {
      var ctx = document.getElementById('userChart');
      var dataCollege = @json($userStats['College']);
      dataCollege = Object.values(dataCollege);
      dataCollege = dataCollege[0].concat(dataCollege[1], dataCollege[2], dataCollege[3]);
      var dataFaculty = @json($userStats['Faculty']);
      dataFaculty = Object.values(dataFaculty);
      dataFaculty = dataFaculty[0].concat(dataFaculty[1], dataFaculty[2], dataFaculty[3]);
      var dataSeniorHigh = @json($userStats['Senior High']);
      dataSeniorHigh = Object.values(dataSeniorHigh);
      dataSeniorHigh = dataSeniorHigh[0].concat(dataSeniorHigh[1], dataSeniorHigh[2], dataSeniorHigh[3]);
      var labelMonths = @json($userStats['Senior High']);
      labelMonths = Object.keys(labelMonths);

      var data = {
        labels: [
          "1", ["2", '\t\t\t\t\t\t\t\t\t'+labelMonths[0]], "3", "4", 
          "1", ["2", '\t\t\t\t\t\t\t\t\t'+labelMonths[1]], "3", "4", 
          "1", ["2", '\t\t\t\t\t\t\t\t\t'+labelMonths[2]], "3", "4", 
          "1", ["2", '\t\t\t\t\t\t\t\t\t'+labelMonths[3]], "3", "4"
        ],
        datasets: [{
          data: dataCollege,
          label: "College",
          borderColor: 'rgba(167, 0, 1, 1)',
          backgroundColor: 'rgba(167, 0, 1, 0.2)',
          fill: true
        }, { 
          data: dataFaculty,
          label: "Faculty",
          borderColor: 'rgba(238, 186, 48, 1)',
          backgroundColor: 'rgba(238, 186, 48, 0.2)',
          fill: true
        }, { 
          data: dataSeniorHigh,
          label: "Senior High",
          borderColor: 'rgba(0, 91, 150, 1)',
          backgroundColor: 'rgba(0, 91, 150, 0.2)',
          fill: true
        }]
      };

      var options = {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
            titleFontSize: 0,
            bodyFontSize: 12,
        },
        scales: {
          xAxes : [{
          gridLines : {
              display : false,
              lineWidth: 1,
              zeroLineWidth: 1,
              zeroLineColor: '#666666',
              drawTicks: false
          },
          ticks: {
              display: true,
              labelString: 'Week of Submission',
              stepSize: 0,
              min: 0,
              autoSkip: false,
              maxRotation: 0,
              minRotation: 0,
              fontSize: 11,
              padding: 12
          }
        }],
          yAxes: [{
                ticks: {
                    precision: 0,
                    beginAtZero: true
                },
                scaleLabel: {
                     display: true,
                     labelString: 'Number of Requests',
                     fontSize: 11
                  }
            }]
        }
      };

      var userLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
      });
    };
  </script>    
@endsection

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
  <ul class="nav navbar-nav">
    @if (Auth()->user()->roles == 0)
      <li class="active"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
      <li class="#"><a href={{URL::route('Reserve')}}>Room Management</a></li>
      <li class="#"><a href={{URL::route('History')}}>Reservation History</a></li>
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
            <div class="col-md-5 col-s-12">
              <div class="callout callout-info">
                <h4>Hello! How are you doing today?</h4>
                <p>
                  You can find pending requests and upcoming reservations for the week here on your dashboard. 
                  <br>Statistics related to user traffic and request status differences are provided for inferencing.
                </p>
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
                          <th>User</th>
                          <th>Date Approved</th>
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
                            <td>{{$form->room_id}} @if($form->room->room_name!=NULL){{$form->room->room_name}}@endif</td>
                            <td>{{$form->user->name}}</td>
                            <td>{{ Carbon::parse($form->updated_at)->toFormattedDateString() }}</td>
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
                  <a href={{URL::route('History')}} class="btn btn-sm btn-default btn-flat pull-right">View Full History</a>
                </div>
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN--> 

            <div class="col-md-7 col-s-12">
              <div class="row">
                <div class="col-md-6">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">User Traffic</h3>
                    </div>
                    <div class="box-body">
                      <div>
                        <canvas id="userChart" height="340" width="auto"></canvas>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="info-box bg-aqua">
                    <span class="info-box-icon"><i class="ion ion-ios-paper-outline"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Requests Received</span>
                      <span class="info-box-number">{{ $formStats['received'][0] }}</span>
        
                      <div class="progress">
                        <div class="progress-bar" style="width: {{ $formStats['received'][1] }}%"></div>
                      </div>
                      <span class="progress-description">
                        {{ $formStats['received'][1] }}% Increase in 30 Days
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>

                  <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="ion ion-ios-checkmark-outline"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Reservations Confirmed</span>
                      <span class="info-box-number">{{ $formStats['confirmed'][0] }}</span>
        
                      <div class="progress">
                        <div class="progress-bar" style="width: {{ $formStats['confirmed'][1] }}%"></div>
                      </div>
                      <span class="progress-description">
                        {{ $formStats['confirmed'][1] }}% Increase in 30 Days
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>

                  <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="ion ion-ios-close-outline"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Requests Rejected</span>
                      <span class="info-box-number">{{ $formStats['rejected'][0] }}</span>
        
                      <div class="progress">
                        <div class="progress-bar" style="width: {{ $formStats['rejected'][1] }}%"></div>
                      </div>
                      <span class="progress-description">
                        {{ $formStats['rejected'][1] }}% Increase in 30 Days
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>

                  <div class="info-box bg-orange">
                    <span class="info-box-icon"><i class="ion ion-sad-outline"></i></span>
        
                    <div class="info-box-content">
                      <span class="info-box-text">Reservations Cancelled</span>
                      <span class="info-box-number">{{ $formStats['cancelled'][0] }}</span>
        
                      <div class="progress">
                        <div class="progress-bar" style="width: {{ $formStats['cancelled'][1] }}%"></div>
                      </div>
                      <span class="progress-description">
                        {{ $formStats['cancelled'][1] }}% Increase in 30 Days
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>
                <!-- /.info-box -->
              </div>

              @include('layouts.alerts.successAlert', ['redirectMessageName' => 'approvedAlert'])
              @include('layouts.alerts.dangerAlert', ['redirectMessageName' => 'rejectedAlert'])
              @include('layouts.alerts.dangerAlert', ['redirectMessageName' => 'cancelledAlert'])
              @include('layouts.modals.infoModal', ['forms' => $pendingforms, 'isOverall' => true, 'isSchedule' => false, 'isApproval' => true])
              @include('layouts.modals.infoModal', ['forms' => $upcomingReservations, 'isOverall' => true, 'isSchedule' => false, 'isApproval' => false])
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Pending Requests</h3>
                </div>

              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Request ID</th>
                        <th>Name</th>
                        <th>Room Number</th>
                        <th>Reservation Period</th>
                        <th>Purpose</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($pendingforms->isEmpty())
                        <tr>
                          <td colspan="6" class="text-center">Everything is good, no pending requests!</td>
                        </tr>
                      @else
                        @foreach($pendingforms as $form)
                        <tr data-toggle="modal" data-target="#reqInfo{{$form->form_id}}" style="cursor: pointer">
                          <td>{{ sprintf("%07d", $form->form_id) }}</td>
                          <td>{{$form->user_id}} {{$form->user->name}}</td>
                          <td>{{$form->room_id}}</td>
                          <td>{{ Carbon::parse($form->stime_res)->format('M d, Y h:i A') }} - {{ Carbon::parse($form->etime_res)->format('M d, Y h:i A') }}</td>
                          <td>{{$form->purpose}}</span></td>
                        </tr>
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div><!--END OF BOX-BODY-->
                <div class="box-footer clearfix">
                </div>
              </div><!--END OF CONTENT BOX-->
            </div><!--END OF COLUMN--> 
          </div><!--END OF ROW-->
        </section><!--END OF ACTUAL CONTENT-->
      </div><!--END OF CONTENT WRAPPER-->
@endsection