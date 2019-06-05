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
var Select2Cascade = ( function(window, $) {

    function Select2Cascade(parent, child, url, select2Options) {
        var afterActions = [];
        var options = select2Options || {};

        // Register functions to be called after cascading data loading done
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

})( window, $);

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
        /* if(checkSpecial==='1' || checkSpecial==='8'){
            $(this).find('input[name="specialReservation"]').val('1');
        } */
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
            //alert(event.title + '\nPeople Involved: ' + event.people + '\nStart: ' + event.start.format('MMMM DD, YYYY hh:mm A') + '\nEnd: ' + event.end.format('MMMM DD, YYYY hh:mm A'));
            $('#reqInfo'+event.formid).modal('show');
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
                    @if($user->user_id == $form->user_id && $form->isCancelled!=1)
                    title: '{{ sprintf("%07d", $form->form_id) }} | {{ $user->name }}', 
                    resourceId: '{{ $form->room_id }}', 
                    @endif
                    start: moment('{{ $form->stime_res }}').format(), 
                    end: moment('{{ $form->etime_res }}').format(),
                    formid: '{{ $form->form_id }}',
                    people: @if($form->users_involved!=NULL) '{{ $form->users_involved }}' @else 'N/A' @endif
                    },
                @endforeach
            @endforeach
        ]
        });

        calendar.render();
    });

    $(document).ready(function() {
        var select2Options = { width: 'resolve' };
        var apiUrl = '/rooms/:parentId:';
        
        $('select').select2(select2Options);                 
        var cascadLoading = new Select2Cascade($('#room_floor'), $('#room_id'), apiUrl, select2Options);

        $('#addReservationBtn').click(function(e) {
            var checkRoom = $.trim($('#room_id').val());
            var checkPurpose = $.trim($('#purpose').val());

            if(checkRoom === '' || checkPurpose === ''){
                //$('#reservationForm').submit();
                //e.stopPropagation();
                $('#addReservationBtn').attr('type','submit');
            }
            else {
            /* when the button in the form, display the entered values in the modal */
            $('#addReservationBtn').attr('type','button');
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
            @elseif(Auth()->user()->roles == 0)
                <h1>Room Management</h1>
            @else 
                <h1>Room Reservation</h1>
            @endif
            <ol class="breadcrumb">
            @if(Auth()->user()->roles == 2)
                <li class="active"><i class="fa fa-building"></i>Room Overview</a></li>
            @elseif(Auth()->user()->roles == 0)
                <li><a href={{URL::route('Dashboard')}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Room Management</li>
            @else
                <li><a href={{URL::route('Dashboard')}}><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Room Reservation</li>
            @endif
            </ol>
        </section>
    
        <!--ACTUAL CONTENT-->
        <section class="content">
            <!--NORMAL ROOM REQUEST INFORMATION MODAL-->
            @foreach($forms as $form)
            <div class="modal fade" id="reqInfo{{$form->form_id}}">
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
                            @foreach ($users as $user)
                                @if ($form->user_id == $user->user_id)
                                    <tr>
                                        <th>Reserved User</th>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                @endif
                            @endforeach
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
                                <td>{{$form->stime_res}} - {{$form->etime_res}}</td>
                            </tr>
                            <tr>
                                <th>Purpose</th>
                                <td>{{$form->purpose}}</td>
                            </tr>
                        </table>
                    </div>
                    @if (Auth()->user()->roles == 0 or Auth()->user()->roles == 1)
                    <div class="modal-footer">
                        @if(\Carbon\Carbon::parse($form->etime_res)->isPast() or $form->isCancelled==1 or $form->isApproved==2)
                            <button type="button" class="btn btn-danger" disabled>Cancel Reservation</button>
                        @else
                            <a type="button" class="btn btn-danger" href="{{ route('cancelrequest', $form->form_id) }}">Cancel Reservation</a>
                        @endif
                    </div>
                    @endif
                    </div>
                </div>
            </div>
            @endforeach
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
            @if(session('roomAlert'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('roomAlert') }}
                    </div>
                </div>
            </div>
            @endif
            @if(session('roomErr'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('roomErr') }}
                    </div>
                </div>
            </div>
            @endif
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

                        {{-- <div class="form-group">
                            <label>Room Number: <span class="text-danger">*</span></label>
                            <select class="form-control" id="room_id" name="room_id" required>
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
                        </div> --}}

                        <div class="form-group">
                            <label>Floor: <span class="text-danger">*</span></label>
                            <select class="form-control" id="room_floor" name="room_floor" required>
                                <option value="" selected disabled>Select floor</option>
                                @foreach ($descriptions as $description)
                                @php
                                $spaces = '/\s+/';
                                $replace = '-';
                                $string= $description;
                                $trimmedDesc = preg_replace($spaces, $replace, strtolower($string));
                                @endphp
                                <option value="{{$trimmedDesc}}">{{$description}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Room Number: <span class="text-danger">*</span></label>
                            <select class="form-control" id="room_id" name="room_id" required>
                                <option>Select room</option>
                            </select>
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

                        <div class="form-group">
                            <label for="reason">Purpose: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Enter purpose here" required></textarea>
                        </div>
                        {{-- <input type="hidden" name="specialReservation" value="0"> --}}
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