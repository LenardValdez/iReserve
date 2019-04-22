@extends('layouts.test')

@section('AdminStyle')
    <style>
        .btn-circle {
          width: 60px;
          height: 60px;
          padding: 10px 16px;
          border-radius: 35px;
          font-size: 24px;
          line-height: 1.33;
          color: steelblue;
        }
    </style>
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
                    <form role="form" id="reservationForm">
                    <div class="form-group">
                        <label for="formName">Name: </label>
                        <input type="text" class="form-control" id="userName" placeholder="Lerma Pantorilla" disabled>
                    </div>

                    <div class="form-group">
                        <label>Room Number: </label>
                        <select class="form-control select2" id="room_ID" required>
                        <optgroup label="8th Floor">
                            <option>801</option>
                            <option>802</option>
                            <option>803</option>
                            <option>804</option>
                            <option>805</option>
                            <option>806</option>
                            <option>807</option>
                        </optgroup>
                        <optgroup label="9th Floor">
                            <option>901</option>
                            <option>902</option>
                            <option>903</option>
                            <option>904</option>
                            <option>905</option>
                            <option>906</option>
                            <option>907</option>
                        </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>People Involved: </label>
                        <select class="form-control select2" id="peopleInvolved" multiple="multiple" data-placeholder="Enter name" required>
                        <option>Miqaela Nicole Banguilan</option>
                        <option>Nicole Kaye Bilon</option>
                        <option>Rhej Christian Laurel</option>
                        <option>Amiel Roseller Saballo </option>
                        <option>Lenard Valdez</option>
                        <option>Janzon Jon Victorio</option>
                        <option>Marikit Valmadrid</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reservation Period: </label>
                        <div class="form-group">
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            <input type="text" class="form-control" id="reservationPeriod" required>
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reason">Purpose: </label>
                        <textarea class="form-control" id="purpose" rows="3" placeholder="Enter purpose here" required></textarea>
                    </div>
                    
                    <button type="button" data-target="#formReview" id="addReservationBtn" data-toggle="modal" class="btn btn-primary pull-right">Add</button>

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
                                    <h4><b>Date: </b>March 20, 2019</h4>
                                    <h4><b>Room Number: </b>901</h4>
                                    <h4><b>People Involved: </b>Mitch Andaya</h4>
                                    <h4><b>Reservation Period: </b>March 24, 2019 02:00PM - March 24, 2019 06:00PM</h4>
                                    <h4><b>Reason: </b>Client Meeting</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Revise</button>
                                    <button type="submit" class="btn btn-success" data-target="#successModal" data-dismiss="modal" data-toggle="modal">Confirm</button>
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
                            <h4>The details have been successfully added to the database and scheduler.</h4>
                        </div>
                        </div>
                    </div>
                    </div>
                </div> <!--END OF BOX-BODY-->  
                </div> <!--END OF CONTENT BOX-->
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
       
        <!--add room-->
        @if (Auth::role()==0)
            @include('pages.adminfunctions.addroom')
        @endif
        <!--end of add room button-->

        </section><!--END OF ACTUAL CONTENT-->
    </div><!--END OF CONTENT WRAPPER-->
@endsection