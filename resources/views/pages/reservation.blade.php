@extends('layouts.app')

@if(Auth()->user()->roles == 2)
    @section('title') Room Overview @endsection
@elseif(Auth()->user()->roles == 0)
    @section('title') Room Management @endsection
@else 
    @section('title') Room Reservation @endsection
@endif

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
                <li class="#"><a id="faqBtn" data-toggle="modal" data-target="#welcomeFAQModal">FAQ</a></li>
            @endif
        </ul>
    </div>
@endsection

@section('script')
    @if (Auth()->User()->roles == 2)
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
        @if(auth()->user()->roles != 2)
        var Select2Cascade = (function(window, $) {
            function Select2Cascade(parent, child, url, select2Options) {
                var afterActions = [];
                var options = select2Options || {};

                this.then = function(callback) {
                    afterActions.push(callback);
                    return this;
                };

                parent.select2(select2Options).on("change", function (e) {
                    child.prop("disabled", true);
                    var _this = this;
                    
                    $.getJSON(url.replace(':parentId:', $(this).val()), function(items) {
                        var newOptions = '<option value="" disabled>Select room</option>';
                        for(var id in items) {
                            newOptions += '<option value="'+ id +'">'+ items[id] +'</option>';
                        }

                        child.select2('destroy').html(newOptions).prop("disabled", false)
                            .select2(options);
                        
                        afterActions.forEach(function (callback) {
                            callback(parent, child, items);
                        });
                    });
                });
            }
            return Select2Cascade;
        })(window, $);

        $(document).ready(function() {
            $('.select2').select2({
                tags: true,
                tokenSeparators: [',']
            });

            $('input.termPeriod').daterangepicker({
                locale: {
                    format: 'MMMM DD, YYYY'
                },
                minDate: moment().startOf('year').subtract(5, 'months'),
                maxDate: moment().startOf('year').add(1, 'years').add(7, 'months'),
                endDate: moment().add(3, 'months')
            });

            $('input.reservationPeriod').daterangepicker({
                timePicker: true,
                autoUpdateInput: false,
                minDate: moment().startOf('month'),
                maxDate: moment().startOf('day').add(3, 'months'),
                @if(auth()->user()->roles == 0)
                startDate: moment().startOf('hour').add(1, 'hours'),
                endDate:  moment().add(3, 'hours'),
                @else
                startDate: moment().add(1, 'days').set({'hours': 7, 'minutes': 30}),
                endDate:  moment().add(1, 'days').set({'hours': 11, 'minutes': 00}),
                maxSpan: {
                    "days": 5
                },
                @endif
                locale: {
                    format: 'MMMM DD, YYYY hh:mm A'
                },
                @if(auth()->user()->roles == 0)
                isInvalidDate: function(date) {
                    return ((moment(date).day() == 0 || moment(date.format("YYYY-MM-DD")).isBefore(moment().format("YYYY-MM-DD"))) ? true : false);
                    
                },
                @else
                isInvalidDate: function(date) {
                    return ((moment(date).day() == 0 || moment(date.format("YYYY-MM-DD")).isBefore(moment().add(1, 'days').format("YYYY-MM-DD"))) ? true : false);
                },
                @endif
                timePickerIncrement: 5
            });

            $('input.reservationPeriod').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MMMM DD, YYYY hh:mm A') + ' - ' + picker.endDate.format('MMMM DD, YYYY hh:mm A'));
            });

            $('input.reservationPeriod').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('#reservationForm').submit(function (ev, picker) {
                [startDate, endDate] = $('.reservationPeriod').val().split(' - ');
                startDate = moment(startDate).format("YYYY-MM-DD HH:mm:ss");
                endDate = moment(endDate).format("YYYY-MM-DD HH:mm:ss");
                $(this).find('input[name="stime_res"]').val(startDate);
                $(this).find('input[name="etime_res"]').val(endDate);
            });

            $('#scheduleDataForm').submit(function (ev, picker) {
                [termStart, termEnd] = $('.termPeriod').val().split(' - ');
                termStart = moment(termStart).format("YYYY-MM-DD");
                termEnd = moment(termEnd).format("YYYY-MM-DD");
                $(this).find('input[name="sdate_term"]').val(termStart);
                $(this).find('input[name="edate_term"]').val(termEnd);
            });

            var select2Options = { width: 'resolve' };
            var apiUrl = '/rooms/:parentId:';
            
            $('select').select2(select2Options);                 
            var cascadLoading = new Select2Cascade($('#room_floor'), $('#room_id'), apiUrl, select2Options);

            $('#addReservationBtn').click(function(e) {
                var checkRoom = $.trim($('#room_id').val());
                var checkDateTime = $.trim($('.reservationPeriod').val());
                var checkPurpose = $.trim($('#purpose').val());

                if(checkRoom === '' || checkPurpose === '' || checkDateTime === ''){
                    $('#addReservationBtn').attr('type','submit');
                }
                else {
                    $('#addReservationBtn').attr('type','button');
                    $('#addReservationBtn').attr('data-toggle','modal');
                    $('#date').text('{{ Carbon::now()->format("M d, Y h:i A") }}');
                    $('#room').text($('#room_id').val());
                    if($.trim($('#peopleInvolved').val()) === '') {
                        $('#people').text('N/A');
                    }
                    else {
                        $('#people').text($('#peopleInvolved').val());
                    }
                    $('#range').text($('#resPeriod').val());
                    $('#reason').text($('#purpose').val());
                }
            });

            $('#purpose').on("input", function(){
                var maxLength = $(this).attr('maxlength');
                var currentCount = $(this).val().length;

                if (currentCount < maxLength) {
                    $('#purposeCount').text(maxLength-currentCount);
                }
                else {
                    $('#purposeCount').text('0');
                }
            });
            
            $('#formConfirmed').click(function () {
                $('#reservationForm').submit();
            });

            $('#addRoomBtn').click(function(e) {
                var checkAddRoom = $.trim($('#addroom_id').val());
                var checkDesc = $.trim($('#room_desc').val());
                var checkStat = $.trim($('#isSpecial').val());

                if(checkAddRoom === '' || checkDesc === '' || checkStat === '') {
                    e.stopPropagation();
                }
            });

            $('#editRoomBtn, #delRoomBtn').click(function(e) {
                var checkModifyRoom = $.trim($('#deleteRoomId').val());
                if(checkModifyRoom === ''){
                    e.stopPropagation();
                }
            });

            $('#roomModifyForm, #deleteScheduleForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var url = (e.target.id == 'roomModifyForm') ? '{{ route("processdelroom") }}' : '{{ route("deleteschedule") }}';
                $('#confirmPassword').removeClass('has-error');
                $('#passwordHelpBlock').text('');

                $.ajax({
                    url:  url,
                    type: 'POST',
                    headers: {
                        accept: 'application/json'
                    },
                    data: formData,
                    success: (response) => {
                        if(response.errors) {
                            if(response.errors.password) {
                                $('#confirmPassword').addClass('has-error');
                                $('#passwordHelpBlock').text('Password entered was incorrect. Please try again.');
                            }
                        }
                        else if (response.success) {
                            sessionStorage.delSuccessMessage = true;
                            sessionStorage.idRemoved = response.idRemoved;
                            window.location.replace("{{ route('Reserve') }}");

                            if(e.target.id == 'roomModifyForm') {
                                sessionStorage.roomDeletion = true;
                            }
                        }
                    }
                });
            });

            if (sessionStorage.getItem('delSuccessMessage') != null) {
                if (sessionStorage.getItem('roomDeletion') != null) {
                    $('#delSuccessTitle').append('<i class="icon fa fa-check"></i>Room ' + sessionStorage.idRemoved + ' has been successfully deleted.');
                    $('#delSuccessMessage').text('Assigned class schedules have been deleted. Any confirmed and pending reservations are now automatically cancelled. Users affected will be notified.');
                }
                else {
                    $('#delSuccessTitle').append('<i class="icon fa fa-check"></i>Class schedule for '+ sessionStorage.idRemoved + ' has been successfully deleted.');
                    $('#delSuccessMessage').text('Corresponding room and time period are now unblocked.');
                    sessionStorage.removeItem('roomDeletion');
                }
                $('#delSuccess').show();
                sessionStorage.removeItem('delSuccessMessage');
                sessionStorage.removeItem('idRemoved');
            }

            $('#delScheduleBtn').click(function(e) {
                var checkDelSchedule = $.trim($('#class_id').val());
                
                if(checkDelSchedule === ''){
                    e.stopPropagation();
                }
            });
        });
        @endif
        
        document.addEventListener('DOMContentLoaded', function() {
            @if(Auth()->user()->roles == 2)
            var classCalendarEl = document.getElementById('classCalendar');
            var classCalendar = new FullCalendar.Calendar(classCalendarEl, {
                plugins: [ 'list' ],
                themeSystem: 'standard',
                timeZone: 'local',
                defaultView: 'listDay',
                noEventsMessage: 'No classes scheduled for today!',
                nowIndicator: 'true',
                views: {
                    listDay: { buttonText: 'day' },
                    listWeek: { buttonText: 'week' },
                    listMonth: { buttonText: 'month' }
                },
                header: {
                    left: 'title',
                    center: '',
                    right: 'listDay,listWeek,listMonth'
                },
                height: 'auto',
                events: [
                    @foreach($classSchedules as $schedule)
                    {
                        @php
                            $days = ["M", "T", "W", "TH", "F", "S"];
                            $dayInDigit = array_search($schedule->day, $days)+1;
                        @endphp
                        title: '{{ $schedule->subject_code }} {{ $schedule->section }} RM. {{ $schedule->room_id }} | {{ $schedule->user->name }}',
                        daysOfWeek: [ '{{ $dayInDigit }}' ],
                        startTime: '{{ $schedule->stime_class }}',
                        endTime: '{{ $schedule->etime_class }}',
                        startRecur: '{{ $schedule->sdate_term }}',
                        endRecur: '{{ $schedule->edate_term }}',
                        extendedProps: {
                            division: '{{ $schedule->division->division_name }}'
                        }
                    },
                    @endforeach
                ],
                eventRender: function(info) {
                    var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
                    dotEl.style.backgroundColor = (info.event.extendedProps.division == 'College') ? 'rgba(250, 128, 114, 1)' : 'rgba(0, 91, 150, 1)';
                }
            });
            classCalendar.render();
            @endif

            var roomCalendarEl = document.getElementById('calendar');
            var roomCalendar = new FullCalendar.Calendar(roomCalendarEl, {
                plugins: [ 'resourceTimeline' ],
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                themeSystem: 'standard',
                timeZone: 'local',
                nowIndicator: 'true',
                header: {
                    left: 'today,prev,next',
                    center: 'title',
                    right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
                },
                businessHours: {
                    daysOfWeek: [ 1, 2, 3, 4 ,5, 6],
                    startTime: '07:30',
                    endTime: '21:00',
                },
                eventClick: function(info){
                    if (info.event.extendedProps.kind == 'reservation') {
                        $('#reqInfo'+info.event.id).modal('show');
                    }
                    else {
                        $('#classInfo'+info.event.id).modal('show');
                    }
                },
                height: 'auto',
                defaultView: 'resourceTimelineDay',
                resourceLabelText: 'Rooms',
                resourceGroupField: 'floorNum',
                resources: [
                    @foreach($rooms as $room)
                        @if(isset($room->room_name))
                            { id: '{{ $room->room_id }}', floorNum: '{{ $room->room_desc }}', title: '{{ $room->room_id }} ({{ $room->room_name}})' },
                        @else
                            { id: '{{ $room->room_id }}', floorNum: '{{ $room->room_desc }}', title: '{{ $room->room_id }}' },
                        @endif
                    @endforeach
                ],
                events: [
                    @if(isset($forms))
                        @foreach($forms as $form)
                            @if($form->isCancelled != 1)
                            {
                            id: '{{ $form->form_id }}',
                            title: '{{ sprintf("%07d", $form->form_id) }} | {{ $form->user->name }}', 
                            resourceId: '{{ $form->room_id }}', 
                            start: moment('{{ $form->stime_res }}').format(), 
                            end: moment('{{ $form->etime_res }}').format(),
                            backgroundColor: 'rgb(0, 91, 150)',
                            borderColor: 'rgb(0, 91, 150)',
                            extendedProps: {
                                kind: 'reservation'
                            },
                            people: @if($form->users_involved!=NULL) '{{ $form->users_involved }}' @else 'N/A' @endif
                            },
                            @endif
                        @endforeach
                    @endif
                    @if(isset($classSchedules))
                        @foreach($classSchedules as $schedule)
                            @php
                                $days = ["M", "T", "W", "TH", "F", "S"];
                                $dayInDigit = array_search($schedule->day, $days)+1;
                            @endphp
                            {
                            id: '{{ $schedule->class_id }}',
                            title: '{{ $schedule->subject_code }} | {{ $schedule->section }}', 
                            resourceId: '{{ $schedule->room_id }}',
                            daysOfWeek: [ '{{ $dayInDigit }}' ],
                            startTime: '{{ $schedule->stime_class }}',
                            endTime: '{{ $schedule->etime_class }}',
                            startRecur: '{{ $schedule->sdate_term }}',
                            endRecur: '{{ $schedule->edate_term }}',
                            backgroundColor: 'rgb(220, 105, 0)',
                            borderColor: 'rgb(220, 105, 0)',
                            extendedProps: {
                                kind: 'class'
                            },
                            people: '{{ $schedule->user_id }}'
                            },
                        @endforeach
                    @endif
                ]
            });
            roomCalendar.render();
        });
    </script>
@endsection

@section('content')
    <!--CONTENT WRAPPER-->
    <div class="content-wrapper">
        @include('layouts.inc.faq')
        <!--PAGE TITLE AND BREADCRUMB-->
        <section class="content-header">
            <h1>@yield('title')</h1>
            <ol class="breadcrumb">
            @if(Auth()->user()->roles == 2)
                <li class="active"><i class="fa fa-building"></i>@yield('title')</a></li>
            @elseif(Auth()->user()->roles == 0)
                <li><a href={{URL::route('Dashboard')}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> @yield('title')</li>
            @else
                <li><a href={{URL::route('Dashboard')}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"> @yield('title')</li>
            @endif
            </ol>
        </section>
    
        <!--ACTUAL CONTENT-->
        <section class="content">
            @if(auth()->user()->roles != 1)
                @include('layouts.modals.infoModal', ['forms' => $forms, 'isOverall' => true, 'isApproval' => false])
            @else
                @include('layouts.modals.infoModal', ['forms' => $forms, 'isOverall' => false, 'isApproval' => false])
            @endif
            <!--CLASS SCHEDULE INFORMATION MODAL-->
            @foreach($classSchedules as $schedule)
            <div class="modal fade" id="classInfo{{$schedule->class_id}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Class Schedule Details</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tr>
                                    <th>Subject</th>
                                    <td>{{ $schedule->subject_code }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $schedule->section }}</td>
                                </tr>
                                <tr>
                                    <th>Professor</th>
                                    <td>{{$schedule->user->name}}</td>
                                </tr>
                                <tr>
                                    <th>Room Number</th>
                                    <td>{{$schedule->room_id}}</td>
                                </tr>
                                <tr>
                                    <th>Day and Time</th>
                                    <td>{{ $schedule->day }} {{ Carbon::parse($schedule->stime_class)->format('h:i A') }} - {{ Carbon::parse($schedule->etime_class)->format('h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if(Auth()->user()->roles == 2)
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Class Schedules</h3>
                            <span class="pull-right">
                                Legend:&nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(250, 128, 114, 1)"></i>&nbsp;College 
                                &nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(0, 91, 150, 1)"></i>&nbsp;Senior High 
                            </span>
                        </div>
                        <div class="box-body">
                            <div id="classCalendar"></div>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Room Availability</h3>
                            <span class="pull-right">
                                Legend:&nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(220, 105, 0, 1)"></i>&nbsp;Regular Class 
                                &nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(0, 91, 150, 1)"></i>&nbsp;Reservation 
                            </span>
                        </div>
                        <div class="box-body">
                            <div id="calendar"></div>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div>
            </div>
            @else
            @include('layouts.alerts.successAlert', ['redirectMessageName' => 'roomAlert'])
            @include('layouts.alerts.dangerAlert', ['redirectMessageName' => 'roomErr'])
            @include('layouts.alerts.dangerAlert', ['redirectMessageName' => 'classErr'])
            @include('layouts.alerts.dangerAlert', ['redirectMessageName' => 'cancelledAlert'])

            <div class="row" style="display: none" id="delSuccess">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 id="delSuccessTitle"></h4>
                        <span style="white-space: pre-wrap" id="delSuccessMessage"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Reservation Form</h3>
                        </div>
                        
                        <div class="box-body">
                            <form role="form" id="reservationForm" method="POST" action="{{route('reserveroom')}}">
                                @csrf
                                <div class="form-group{{ $errors->receive->has('user_id') ? ' has-error' : '' }}">
                                    <label for="formName">Name: </label>
                                    <input type="text" class="form-control" placeholder="{{Auth()->user()->name}}" disabled>
                                    <input type="hidden" value="{{ Auth()->user()->user_id }}" name="user_id">
                                    @if ($errors->receive->has('user_id'))
                                        <span class="help-block" role="alert">
                                        {{ $errors->receive->first('user_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Floor: <span class="text-danger">*</span></label>
                                    <select class="form-control" id="room_floor" name="room_floor" required>
                                        <option value="" selected disabled>Select floor</option>
                                        @foreach ($descriptions as $description)
                                        @php
                                        $trimmedDesc = preg_replace('/\s+/', '-', strtolower($description));
                                        @endphp
                                        <option value="{{$trimmedDesc}}">{{$description}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->receive->has('room_id') ? ' has-error' : '' }}">
                                    <label>Room Number: <span class="text-danger">*</span></label>
                                    <select class="form-control" id="room_id" name="room_id" required>
                                        <option>Select room</option>
                                    </select>
                                    @if ($errors->receive->has('room_id'))
                                        <span class="help-block" role="alert">
                                        {{ $errors->receive->first('room_id') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>People Involved: </label>
                                    <select class="form-control select2" style="width:100%!important;" id="peopleInvolved" name="users_involved[]" multiple="multiple" data-placeholder="Enter name">
                                        @foreach ($users as $user)
                                            @if ($user->user_id != Auth()->user()->user_id and $user->roles == 1)
                                                <option value="{{$user->name}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group{{ ($errors->receive->has('stime_res') || $errors->receive->has('etime_res')) ? ' has-error' : '' }}">
                                    <label>Reservation Period{{ (auth()->user()->roles == 1) ? ' (max. 5 days)' : '' }}: <span class="text-danger">*</span></label>
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <input type="text" class="form-control reservationPeriod" id="resPeriod" placeholder="Enter reservation period" required>
                                        <input type="hidden" name="stime_res" id="start">
                                        <input type="hidden" name="etime_res" id="end">
                                    </div>
                                    <small class="text-danger">{{ session('existingErr') }}</small>
                                    @if ($errors->receive->has('stime_res') || $errors->receive->has('etime_res'))
                                        <span class="help-block" role="alert">
                                        @if ($errors->receive->has('stime_res'))
                                        {{ $errors->receive->first('stime_res') }}
                                        @else
                                        {{ $errors->receive->first('etime_res') }}
                                        @endif
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->receive->has('purpose') ? ' has-error' : '' }}">
                                    <label for="reason">Purpose: <span class="text-danger">*</span></label><small class="pull-right text-muted"><span id="purposeCount">255</span>/255</small>
                                    <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Enter purpose here" maxlength="255" required></textarea>
                                    @if ($errors->receive->has('purpose'))
                                    <span class="help-block" role="alert">
                                    {{ $errors->receive->first('purpose') }}
                                    </span>
                                @endif
                                </div>
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
                                                <button type="submit" class="btn btn-success" id="formConfirmed">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> <!--END OF BOX-BODY-->
                    </div> <!--END OF CONTENT BOX-->
                    <!--ROOM AND SCHEDULE MANAGEMENT-->
                    @if (Auth()->user()->roles == 0)
                        @include('pages.adminfunctions.room')
                        @include('pages.adminfunctions.schedule')
                    @endif
                    <!--END OF ROOM AND SCHEDULE MANAGEMENT FORMS-->
                </div> <!--END OF COLUMN-->

                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Room Availability</h3>
                            <span class="pull-right">
                                Legend:&nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(220, 105, 0, 1)"></i>&nbsp;Regular Class 
                                &nbsp;&nbsp;
                                <i class="ion ion-record" style="color: rgba(0, 91, 150, 1)"></i>&nbsp;Reservation 
                            </span>
                        </div>
                        <div class="box-body">
                            <div id="calendar"></div>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div> <!--END OF COLUMN-->
            </div> <!--END OF ROW-->
        @endif
        </section><!--END OF ACTUAL CONTENT-->
    </div><!--END OF CONTENT WRAPPER-->
@endsection