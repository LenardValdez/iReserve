<div class="modal fade" id="welcomeFAQModal">
    <div class="modal-dialog" role="document">
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
                            @if (Auth()->user()->roles == 2)
                            <h4 class="box-title text-info">Where can I view class schedules and reservations?</h4>
                            @else
                                <h4 class="box-title text-info">How can I reserve a room?</h4>
                            @endif
                        </div>

                        <div id="collapseOne" class="panel-collapse collapse in">
                            @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                                <div class="box-body">
                                    <dl>
                                        <dt>Step 1</dt>
                                        <dd>Click on the <strong>Room Management</strong> tab on the navbar.</dd>
                                        <dt>Step 2</dt>
                                        <dd>Fill up the Reservation Form accordingly.</dd>
                                        <dt>Step 3</dt>
                                        <dd>Click on the <strong>Submit</strong> button.</dd>
                                        <dt>Step 4</dt>
                                        <dd>Click on the <strong>Confirm</strong> button once you have reviewed your given details.</dd>
                                    </dl>
                                    <p><strong>NOTE</strong>: Check the calendar to make sure that no overlapping admin-hosted timeslot is in place for your preferred schedule.</p>
                                </div>
                            @elseif (Auth()->user()->roles == 1) <!--User FAQ-->
                                <div class="box-body">
                                    <dl>
                                        <dt>Step 1</dt>
                                        <dd>Click on the <strong>Room Reservation</strong> tab on the navbar.</dd>
                                        <dt>Step 2</dt>
                                        <dd>Fill up the Reservation Form accordingly.</dd>
                                        <dt>Step 3</dt>
                                        <dd>Click on the <strong>Submit</strong> button.</dd>
                                        <dt>Step 4</dt>
                                        <dd>Click on the <strong>Confirm</strong> button once you have reviewed your given details.</dd>
                                    </dl>
                                    <p><strong>NOTE</strong>: Check the calendar to make sure that no overlapping timeslot is in place for your preferred schedule.</p>
                                </div>
                            @else <!--User FAQ-->
                                <div class="box-body">
                                    <dl>
                                        <dt>Step 1</dt>
                                        <dd>Click on the <strong>Room Overview</strong> tab on the navbar. This is also the same as your default homepage.</dd>
                                        <dt>Step 2</dt>
                                        <dd>
                                            For class schedules, you can navigate on the list on the left side to your liking. 
                                            For reservations, you may check for the room to be inspected through the calendar on
                                            the right side. To reveal information, click on the corresponding colored block. 
                                            You may also check reservations through the <strong>Reservation History</strong> page, 
                                            which has a function that allows you to generate reservation logs by saving history as a PDF.
                                        </dd>
                                    </dl>
                                    <p>
                                        <strong>NOTE:</strong> For security reasons, only users and/or organizations declared 
                                        as <strong>Users Involved</strong> are permitted inside the reserved room.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(Auth()->user()->roles == 0)
                        <div class="panel box box-primary">
                            <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseAdmin1">
                                <h4 class="box-title text-info">How can I add a new room?</h4>
                            </div>

                            <div id="collapseAdmin1" class="panel-collapse collapse">
                                <div class="box-body">
                                    <dl>
                                        <dt>Step 1</dt>
                                        <dd>Click on the <strong>Room Management</strong> tab on the navbar.</dd>
                                        <dt>Step 2</dt>
                                        <dd>Fill up the Add New Room Form accordingly.</dd>
                                        <dt>Step 3</dt>
                                        <dd>Click on the <strong>Add</strong> button.</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="panel box box-primary">
                            <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseAdmin2">
                                <h4 class="box-title text-info">How can I import this term's class schedules?</h4>
                            </div>
    
                            <div id="collapseAdmin2" class="panel-collapse collapse">
                                <div class="box-body">
                                    <dl>
                                        <dt>Step 1</dt>
                                        <dd>Click on the <strong>Room Management</strong> tab on the navbar.</dd>
                                        <dt>Step 2</dt>
                                        <dd>Fill up the Insert Class Schedule Form accordingly.</dd>
                                        <dt>Step 3</dt>
                                        <dd>Click on the <strong>Insert</strong> button.</dd>
                                    </dl>
                                    <p><strong>NOTE</strong>: You may click on the <strong>What should be the format?</strong> text to see the CSV Format Guide.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="panel box box-primary">
                    <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseTwo">
                        <h4 class="box-title text-info">Room Reservation Policy</h4>
                    </div>

                    <div id="collapseTwo" class="panel-collapse collapse">
                        @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                            <div class="box-body">
                                <p><strong>As the room manager, please be aware of these policies: </strong><br>
                                    <ul>
                                        <li>
                                            Any student or faculty member who violates any rule in the school
                                            handbook shall be disciplined accordingly.
                                        </li>
                                    </ul>
                            
                                    <ul>
                                        <li>
                                            Damage occurring during the use of the room 
                                        will be the responsibility of the person who submitted
                                        the reservation.
                                        </li>
                                    </ul>
                                
                                    <ul>
                                        <li> 
                                            If the room is labeled is a <strong>Special Room</strong> 
                                        (such as labs and function rooms), you must wait for the 
                                        approval of the Room Manager before using the room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> Users and/or organizations that are not included in 
                                        the declared <strong>Users Involved</strong> are not permitted 
                                        inside the reserved room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> 
                                            Regular room reservations (i.e. normal classrooms) are 
                                        automatically approved unless a reservation is already in place.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            Selectable dates for reservation period will only be limited to 
                                            the next 3 months. The current day is also disabled for the start
                                            date to respect the room manager's provided lead time.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            A valid reason is required to cancel pending/confirmed reservations.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            Users are only allowed to submit 5 requests per day. The admin account, 
                                            on the other hand, can submit unlimited requests. All admin-hosted 
                                            reservations will also automatically override overlapping reservations 
                                            of normal users.
                                        </li>
                                    </ul>
                                </p>
                            </div>
                        @elseif(Auth()->user()->roles == 1) <!--User FAQ-->
                            <div class="box-body">
                                <p>
                                    <ul>
                                        <li>
                                            Any student or faculty member who violates any rule in the school
                                            handbook shall be disciplined accordingly.
                                        </li>
                                    </ul>
                            
                                    <ul>
                                        <li>
                                            Damage occurring during the use of the room 
                                        will be the responsibility of the person who submitted
                                        the reservation.
                                        </li>
                                    </ul>
                                
                                    <ul>
                                        <li> 
                                            If the room is labeled is a <strong>Special Room</strong> 
                                        (such as labs and function rooms), you must wait for the 
                                        approval of the Room Manager before using the room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> Users and/or organizations that are not included in 
                                        the declared <strong>Users Involved</strong> are not permitted 
                                        inside the reserved room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> 
                                            Regular room reservations (i.e. normal classrooms) are 
                                        automatically approved unless a reservation is already in place.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            Selectable dates for reservation period will only be limited to 
                                            the next 3 months.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            Submit a request at least 24 hours before your preferred start date 
                                            to give the admin time to review your request.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            A valid reason is required to cancel pending/confirmed reservations.
                                        </li>
                                    </ul>

                                    <ul>
                                        <li> 
                                            Users are only allowed to submit 5 requests per day. The admin account, 
                                            on the other hand, can submit unlimited requests. All admin-hosted 
                                            reservations will also automatically override overlapping reservations 
                                            of normal users.
                                        </li>
                                    </ul>
                                </p>
                            </div>
                        @else
                            <div class="box-body">
                                <p><strong>As part of the security personnel, please be aware of these policies: </strong><br>
                                    <ul>
                                        <li>
                                            Any student or faculty member who violates any rule in the school
                                            handbook shall be disciplined accordingly.
                                        </li>
                                    </ul>
                            
                                    <ul>
                                        <li>
                                            Damage occurring during the use of the room 
                                        will be the responsibility of the person who submitted
                                        the reservation.
                                        </li>
                                    </ul>
                                
                                    <ul>
                                        <li> 
                                            If the room is labeled is a <strong>Special Room</strong> 
                                        (such as labs and function rooms), you must wait for the 
                                        approval of the Room Manager before using the room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> Users and/or organizations that are not included in 
                                        the declared <strong>Users Involved</strong> are not permitted 
                                        inside the reserved room.
                                        </li>
                                    </ul>
                                    
                                    <ul>
                                        <li> 
                                            Regular room reservations (i.e. normal classrooms) are 
                                        automatically approved unless a reservation is already in place.
                                        </li>
                                    </ul>
                                </p>
                            </div>
                        @endif
                    </div>
                    </div>

                    <div class="panel box box-primary">
                    <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseThree">
                        <h4 class="box-title text-info">Contact Information</h4>
                    </div>

                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>For Technical Support:<br>
                                    Mail: <a href="mailto:infotech@iacademy.edu.ph">infotech@iacademy.edu.ph</a><br>
                                    Local call:<a href="tel:22232228"> 2223-2228</a><br>
                                    External call:<a href="tel:028895555">(02)889-5555</a><br><br>
                                </div>
                                <div class="col-md-6">
                                    iAcademy Nexus Campus,<br>
                                    7434 Yakal Street, Barangay. San Antonio,<br>
                                    Makati City, 1203<br>
                                    Mail: <a href="mailto:academics@iacademy.edu.ph">academics@iacademy.edu.ph</a><br>
                                    Call:<a href="tel:028895555"> (02)889-5555</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>