@extends('layouts.app')

@section('menu')
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
        @if (Auth()->user()->roles == 0)
            <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
            <li class="active"><a href={{URL::route('Reserve')}}>Room Management</a></li>
            <li class="#"><a href={{URL::route('History')}}>Reservation History</a></li>
            <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
        @elseif (Auth()->user()->roles == 1)
            <li class="#"><a href={{ URL::route('Dashboard') }}>Dashboard</a></li>
            <li class="active"><a href={{URL::route('Reserve')}}>Room Reservation</a></li>
            <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
        @else 
            <li class="active"><a href={{ URL::route('Dashboard') }}>Room Overview</a></li>
            <li class="#"><a href={{URL::route('History')}}>Reservation History</a></li>
        @endif
    </ul>
</div>
@endsection

@section('script')
<script>
$(function () {
    $('.select2').select2({
        tags: true,
        tokenSeparators: [',']
    });

    $('input.reservationPeriod').daterangepicker({
    timePicker: true,
    minDate: moment(),
    maxDate: moment().startOf('hour').add(3, 'months'),
    locale: {
        format: 'MMMM DD, YYYY hh:mm A'
    },
    timePickerIncrement: 30
    });

    $('#reservationForm').submit(function (ev, picker) {
        var checkSpecial = $('#room_id').val().substr(0, 1);
        [startDate, endDate] = $('.reservationPeriod').val().split(' - ');
        if(checkSpecial==='1' || checkSpecial==='8'){
            $(this).find('input[name="specialReservation"]').val('1');
        }
        startDate = moment(startDate).format("YYYY-MM-DD HH:mm:ss");
        endDate = moment(endDate).format("YYYY-MM-DD HH:mm:ss");
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
        themeSystem: 'bootstrap3',
        header: {
            left: 'today prev,next',
            center: 'title',
            right: 'timelineDay,timelineWeek,timelineMonth'
        },
        businessHours: {
            dow: [ 1, 2, 3, 4 ,5, 6],

            start: '07:30',
            end: '21:00',
        },
        eventClick: function(event){
            alert(event.title + '\nPeople Involved: ' + event.people + '\nStart: ' + event.start.format('hh:mm A') + '\nEnd: ' + event.end.format('hh:mm A'));
        },
        height: '800',
        defaultView: 'timelineDay',
        resourceLabelText: 'Rooms',
        resourceGroupField: 'floorNum',
        resources: [
            @foreach($rooms as $room)
            { id: '{{ $room->room_id }}', floorNum: '{{ $room->room_desc }}', title: '{{ $room->room_id }}' },
            @endforeach
        ],
        events: [
            @foreach($users as $user)
                @foreach($forms as $form)
                    {
                    @if($user->user_id == $form->user_id)
                    title: '{{ sprintf("%07d", $form->form_id) }} | {{ $user->name }}', 
                    resourceId: '{{ $form->room_id }}', 
                    @endif
                    start: moment('{{ $form->stime_res }}').format(), 
                    end: moment('{{ $form->etime_res }}').format()
                    },
                @endforeach
            @endforeach
        ]
        });

        calendar.render();
    });

    $(document).ready(function() {
        $('#addReservationBtn').click(function(e) {
            var checkRoom = $.trim($('#room_id').val());
            var checkPurpose = $.trim($('#purpose').val());

            if(checkRoom === '' || checkPurpose === ''){
                //$('#reservationForm').submit();
                e.stopPropagation();
            }
            else {
            /* when the button in the form, display the entered values in the modal */
            $('#addReservationBtn').attr('data-toggle','modal');
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

        @include('layouts.inc.faq')

        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
            @if(Auth()->user()->roles == 2)
                <h1>Room Overview</h1>
            @else
                <h1>Room Reservation</h1>
            @endif
            <ol class="breadcrumb">
            @if(Auth()->user()->roles == 2)
                <li class="active"><i class="fa fa-building"></i>Room Overview</a></li>
            @else
                <li><a href={{URL::route('Dashboard')}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Room Reservation</li>
            @endif
            </ol>
        </section>
    
        <!--ACTUAL CONTENT-->
        <section class="content">
            @if(Auth()->user()->roles == 2)
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Room Availability</h3>
                        </div>
                        <div class="box-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reservation Form</h3>
                    </div>
                    
                    <div class="box-body">
                        <form role="form" id="reservationForm" method="POST" action="{{route('reserveroom')}}">
                        @csrf
                        <div class="form-group">
                            <label for="formName">Name: </label>
                            <input type="text" class="form-control" placeholder="{{Auth::user()->name}}" disabled>
                        </div>

                        <div class="form-group {{ $errors->has('room_id') ? ' has-error' : '' }}">
                            <label>Room Number: <span class="text-danger">*</span></label>
                            <select class="form-control{{ $errors->has('room_id') ? ' has-error' : '' }}" id="res_id" name="room_id" required>
                                <option value="" selected disabled>Select an available room</option>
                                @foreach ($descriptions as $description)
                                <optgroup label="{{$description}}">
                                    @foreach ($rooms as $room)
                                    @if ($description == $room->room_desc)
                                        @if (Auth()->user()->roles==1)
                                            @if ($room->isSpecial==1)
                                                <option value="{{$room->room_id}}">{{$room->room_id}} *requires approval</option>
                                            @else
                                                <option value="{{$room->room_id}}">{{$room->room_id}}</option>
                                            @endif
                                        @else
                                            <option value="{{$room->room_id}}">{{$room->room_id}}</option>
                                        @endif
                                    @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            @if ($errors->has('room_id'))
                            <span class="help-block" role="alert">
                                <strong>{{ $errors->first('room_id') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>People Involved: </label>
                            <select class="form-control select2" style="width:100%!important;" id="peopleInvolved" name="users_involved[]" multiple="multiple" data-placeholder="Enter name" required>
                                @foreach ($users as $user)
                                    @if ($user->user_id != Auth()->user()->user_id and $user->roles == 1)
                                        <option value="{{$user->name}}">{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Reservation Period: <span class="text-danger">*</span></label>
                            <div class="form-group">
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <input type="text" class="form-control reservationPeriod" id="resPeriod" required>
                                <input type="hidden" name="stime_res" id="start">
                                <input type="hidden" name="etime_res" id="end">
                            </div>
                            <small class="text-danger">{{ session('existingErr') }}</small>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('puspose') ? ' has-error' : '' }}">
                            <label for="reason">Purpose: <span class="text-danger">*</span></label>
                            <textarea class="form-control{{ $errors->has('purpose') ? ' has-error' : '' }}" id="purpose" name="purpose" rows="3" placeholder="Enter purpose here" required></textarea>
                            @if ($errors->has('purpose'))
                            <span class="help-block" role="alert">
                                <strong>{{ $errors->first('purpose') }}</strong>
                            </span>
                            @endif
                        </div>
                        <input type="hidden" name="specialReservation" value="0">
                        <p class="text-red pull-left"><span class="text-danger">*</span> items are required</p>
                        <button type="button" data-target="#formReview" value="Submit" id="addReservationBtn" class="btn btn-primary pull-right">Submit</button>

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
                                        @if(Auth()->user()->roles == 0)
                                        <p>Any non-admin requests for this room number with similar reservation period will be overriden.</p>
                                        @endif
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

                <div class="col-md-8">
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
        @endif
        </section><!--END OF ACTUAL CONTENT-->
    </div><!--END OF CONTENT WRAPPER-->
@endsection