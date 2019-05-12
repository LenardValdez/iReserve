@extends('layouts.app')

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
        @if (Auth()->user()->roles == 0)
        <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
        <li class="active"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
        <li class="#"><a href={{URL::route('History')}}>Reservation History</a></li>
        @elseif (Auth()->user()->roles == 1)
        <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
        <li class="active"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
        @endif
    </ul>
</div>
@endsection

@section('script')
<script src="js/adminlte_js/jquery.min.js"></script>
<script src="js/adminlte_js/bootstrap.min.js"></script>
<script src="js/adminlte_js/moment.min.js"></script> <!--DATE FORMAT BEING USED BY DATERANGEPICKER-->
<script src="js/adminlte_js/select2.full.min.js"></script> <!--JS FOR MULTIPLE SELECT FORM INPUT-->
<script src="js/adminlte_js/daterangepicker.js"></script> <!--JS FOR DATE AND TIME RANGE-->
<script src="js/adminlte_js/jquery.slimscroll.min.js"></script>
<script src="js/adminlte_js/adminlte.min.js"></script>
<script src="js/adminlte_js/fullcalendar.min.js"></script> <!--CHANGE FORM DATE AND TIME FORMAT TO ISO8601 STRING USING moment().toISOString()-->
<script src="js/adminlte_js/fullcalendar-scheduler.min.js"></script>

<script>
$(function () {
    $('.select2').select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $('input.reservationPeriod').daterangepicker({
    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    maxDate: moment().startOf('hour').add(3, 'months'),
    locale: {
        format: 'YYYY-MM-DD HH:mm:ss'
    }
    });

    $('#reservationForm').submit(function (ev, picker) {
        [startDate, endDate] = $('.reservationPeriod').val().split(' - ');
        $(this).find('input[name="stime_res"]').val(startDate);
        $(this).find('input[name="etime_res"]').val(endDate);
    });

    $('#addRoomBtn').click(function(e) {
        var checkAddRoom = $.trim($('#addroom_id').val());
        var checkDesc = $.trim($('#room_desc').val());
        var checkStat = $.trim($('#isSpecial').val());

        if(checkAddRoom === '' || checkDesc === '' || checkStat === ''){
            e.stopPropagation();
        }
    });

    $('#delRoomBtn').click(function(e) {
        var checkDelRoom = $.trim($('#delroom_id').val());
        
        if(checkDelRoom === ''){
            e.stopPropagation();
        }
    });

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

    $(document).ready(function() {
        $('#addReservationBtn').click(function(e) {
            var checkRoom = $.trim($('#room_id').val());
            var checkPurpose = $.trim($('#purpose').val());
            
            if(checkRoom === '' || checkPurpose === ''){
                e.stopPropagation();
            }
            else {
            /* when the button in the form, display the entered values in the modal */
            $('#date').text('{{ \Carbon\Carbon::now()->toDayDateTimeString() }}');
            $('#room').text($('#room_id').val());
            $('#people').text($('#peopleInvolved').val());
            $('#range').text($('#resPeriod').val());
            $('#reason').text($('#purpose').val());
            }
        });
        $('#formConfirmed').click(function () {
            $('#reservationForm').submit();
        });
    });
</script>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
            <h1>Room Reservation</h1>
            <ol class="breadcrumb">
            <li><a href="admindash.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Room Reservation</li>
            </ol>
        </section>
    
        <!--ACTUAL CONTENT-->
        <section class="content">
            <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Reservation Form</h3>
                </div>
                
                <div class="box-body">
                    <form role="form" id="reservationForm" method="POST" action="{{route('reserveroom')}}">
                    @csrf
                    <div class="form-group">
                        <label for="formName">Name: </label>
                        <input type="text" class="form-control"  placeholder="{{Auth::user()->name}}" disabled>
                    </div>

                    <div class="form-group">
                        <label>Room Number: </label>
                        <select class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" id="room_id" name="room_id" required>
                            <option value="" selected disabled>Select an available room</option>
                            @foreach ($descriptions as $description)
                              <optgroup label="{{$description}}">
                                @foreach ($rooms as $room)
                                  @if ($description == $room->room_desc)
                                    <option value="{{$room->room_id}}">{{$room->room_id}}</option>
                                  @endif
                                @endforeach
                              </optgroup>
                            @endforeach
                        </select>
                        @if ($errors->has('room_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('room_id') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>People Involved: </label>
                        <select class="form-control select2" id="peopleInvolved" name="users_involved[]" multiple="multiple" data-placeholder="Enter name" required>
                            @foreach ($users as $user)
                                @if ($user->user_id != Auth()->user()->user_id and $user->roles == 1)
                                    <option value="{{$user->name}}">{{$user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reservation Period: </label>
                        <div class="form-group">
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            <input type="text" class="form-control reservationPeriod" id="resPeriod" required>
                            <input type="hidden" name="stime_res" id="start">
                            <input type="hidden" name="etime_res" id="end">
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason">Purpose: </label>
                        <textarea class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" id="purpose" name="purpose" rows="3" placeholder="Enter purpose here" required></textarea>
                        @if ($errors->has('purpose'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('purpose') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <button type="button" data-target="#formReview" value="Submit" id="addReservationBtn" data-toggle="modal" class="btn btn-primary pull-right">Submit</button>

                    <!--FORM REVIEW MODAL+SUBMIT-->
                    <div class="modal fade" id="formReview">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Summary of Reservation</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tr>
                                            <th>Date</th>
                                            <td id="date"></td>
                                        </tr>
                                        <tr>
                                            <th>Room Number</th>
                                            <td id="room"></td>
                                        </tr>
                                        <tr>
                                            <th>People Involved</th>
                                            <td id="people"></td>
                                        </tr>
                                        <tr>
                                            <th>Reservation Period</th>
                                            <td id="range"></td>
                                        </tr>
                                        <tr>
                                            <th>Purpose</th>
                                            <td id="reason"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Revise</button>
                                    <button type="submit" class="btn btn-success" id="formConfirmed" data-target="#successModal" data-dismiss="modal" data-toggle="modal">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                    <!--ADD-RESERVATION CONFIRMATION MODAL-->
                    <div class="modal fade" id="successModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Reservation Confirmed</h4>
                            </div>
                            <div class="modal-body">
                                <h4>The scheduler has been updated.</h4>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!--ADD-ROOM CONFIRMATION MODAL-->
                    <div class="modal fade" id="successRoomModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Room Database Updated</h4>
                        </div>
                        <div class="modal-body">
                            <h4>The database and scheduler have been successfully updated.</h4>
                        </div>
                        </div>
                    </div>
                    </div>
                </div> <!--END OF BOX-BODY-->
                </div> <!--END OF CONTENT BOX-->

                <!--add-delete room-->
                @if (Auth()->user()->roles == 0)
                    @include('pages.adminfunctions.adddel')
                @endif
                <!--end of add-delete room button-->

            </div> <!--END OF COLUMN-->

            <div class="col-md-7">
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Room Availability</h3>
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
                </div>
            </div> <!--END OF COLUMN-->
            </div> <!--END OF ROW-->

        </section><!--END OF ACTUAL CONTENT-->
    </div><!--END OF CONTENT WRAPPER-->
@endsection