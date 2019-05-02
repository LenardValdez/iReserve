@extends('layouts.test')

@section('script')
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/jquery.slimscroll.min.js"></script>
  <script src="js/adminlte.min.js"></script>
  <script src="js/fullcalendar.min.js"></script>
  <script src="js/fullcalendar-scheduler.min.js"></script>
  <script>
    $(function() {
      $('#calendar').fullCalendar({
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        header: {
          left: 'today prev,next',
          center: 'title',
          right: 'timelineDay,timelineWeek,month'
        },
        businessHours: {
          dow: [ 1, 2, 3, 4 ,5, 6],

          start: '07:00',
          end: '22:00',
        },
        height: '800',
        defaultView: 'timelineDay',
        resourceGroupField: 'floorNum',
        resources: [
          { id: '801', floorNum: '8th Floor', title: 801 },
          { id: '802', floorNum: '8th Floor', title: 802 },
          { id: '803', floorNum: '8th Floor', title: 803 },
          { id: '804', floorNum: '8th Floor', title: 804 },
          { id: '805', floorNum: '8th Floor', title: 805 },
          { id: '806', floorNum: '8th Floor', title: 806 },
          { id: '901', floorNum: '9th Floor', title: 901 },
          { id: '902', floorNum: '9th Floor', title: 902 },
          { id: '903', floorNum: '9th Floor', title: 903 },
          { id: '904', floorNum: '9th Floor', title: 904 },
          { id: '905', floorNum: '9th Floor', title: 905 },
          { id: '906', floorNum: '9th Floor', title: 906 },
          { id: '907', floorNum: '9th Floor', title: 907 }
        ],
        /*modal for each cell - security and room manager-exclusive function*/
        select: function(startDate, endDate, jsEvent, view, resource) {
          alert('Reserved from ' + startDate.format() + ' to ' + endDate.format() + ' - Room ' + resource.id);
        }
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