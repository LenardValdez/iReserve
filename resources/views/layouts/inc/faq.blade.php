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
                        @if (Auth()->user()->roles == 2)
                        <h4 class="box-title text-info">How to view reserved room info</h4>
                        @else
                            <h4 class="box-title text-info">How to Reserve A Room</h4>
                        @endif
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in">
                        @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                            <div class="box-body" style="margin:0 20px;">
                                <p><ul><li><strong>Step 1:</strong></li>
                                <ul><li>Go to Room reservation tab.</li></ul><br>
                            
                                <li><strong>Step 2:</strong></li>
                                <ul><li>Fill up the Room number, People Involved,
                                Reservation Period, and Purpose sections accordingly.</li></ul>
                            
                                <li><strong>Step 3:</strong></li>
                                <ul><li> the Submit button.</li></ul><br></ul>
                            
                                <strong>Note:
                                You can use the calendar to see what time slot is available on the prefered room of booking.
                                </strong></p>
                            </div>
                        @elseif (Auth()->user()->roles == 1) <!--User FAQ-->
                            <div class="box-body" style="margin:0 20px;">
                                <p><ul><li><strong>Step 1:</strong></li>
                                <ul><li>Go to Room reservation tab.</li></ul><br>
                            
                                <li><strong>Step 2:</strong></li>
                                <ul><li>Fill up the Room number, People Involved,
                                Reservation Period, and Purpose sections accordingly.</li></ul><br>
                            
                                <li><strong>Step 3:</strong></li>
                                <ul><li> the Submit button.</li></ul><br>
                                
                                <li><strong>Step 4:(Booking a Special Room)</strong></li>
                                <ul><li>Wait for the Room Manager's approval.</li></ul><br>
                            
                                <li><strong>Note:
                                 You can use the calendar to see what time slot is available on the prefered room of booking.
                                </strong></li></ul></p>
                            </div>
                        @else <!--User FAQ-->
                            <div class="box-body" style="margin:0 20px;">
                                <p><ul><li><strong>Step 1:</strong></li>
                                <ul><li>Go to Room overview tab.</li></ul><br>
                            
                                <li><strong>Step 2:</strong></li>
                                <ul><li>Look for the room being inspected in the calendar</li></ul><br>
                            
                                <li><strong>Step 3:</strong></li>
                                <ul><li>Tap the room reservation schedule to reveal the complete information</li></ul><br>
                            
                                <li><strong>Note:
                                For security reasons please only allow students that are in the list of "people involved" to stay in the rserved room
                                </strong></li></ul></p>
                            </div>
                        @endif
                    </div>
                    </div>

                    <div class="panel box box-primary">
                    <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseTwo">
                        <h4 class="box-title text-info">Room Reservation Policy</h4>
                    </div>

                    <div id="collapseTwo" class="panel-collapse collapse">
                        @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                            <div class="box-body" style="margin:0 10px;">
                                <p><strong>As room Manager, please be aware of these policies: </strong><br>
                                    <ul><li>Students/Faculty that violates any rule in the school
                                handbook will be disciplined accordingly.</li></ul>
                            
                                <ul><li> Damage occurring during the use of the room 
                                    will be the responsibility of the person who made
                                    the reservation.</li></ul>
                            
                                <ul><li> A room is labeled as a "Special Room", you
                                    must wait for the approval of the Room Manager
                                    in order to use the room.</li></ul>
                                
                                <ul><li> Students that are not listed on "Students involved"
                                    section are not allowed on the reserved room.</li></ul>
                                
                                <ul><li> Regular rooms are automatically approved.</li></ul>

                                <ul><li> Users can only reserve a room on a date that
                                    is within three months.</li></ul></p>
                            </div>
                        @elseif(Auth()->user()->roles == 1) <!--User FAQ-->
                            <div class="box-body" style="margin:0 10px;">
                                <p><ul><li>Students/Faculty that violates any rule in the school
                                handbook will be disciplined accordingly.</li></ul>
                            
                                <ul><li> damage occurring during the use of the room 
                                    will be the responsibility of the person who made
                                    the reservation.</li></ul>
                            
                                <ul><li> a room is labeled as a "Special Room", you
                                    must wait for the approval of the Room Manager
                                    in order to use the room.</li></ul>
                                
                                <ul><li> Students that are not listed on "Students involved"
                                    section are not allowed on the reserved room.</li></ul>
                                
                                <ul><li> Regular rooms are automatically approved.</li></ul>

                                <ul><li> Users can only reserve 5 rooms per day</li></ul>
                                
                                <ul><li> Users can only reserve a room on a date that
                                    is within three months.</li></ul></p>
                            </div>
                        @else
                            <div class="box-body" style="margin:0 10px;">
                                <p><strong>As a Security personnel, please be aware of these policies: </strong><br>
                                    <ul><li>Students/Faculty that violates any rule in the school
                                handbook will be disciplined accordingly.</li></ul>
                            
                                <ul><li> Damage occurring during the use of the room 
                                    will be the responsibility of the person who made
                                    the reservation.</li></ul>
                            
                                <ul><li> A room is labeled as a "Special Room", you
                                    must wait for the approval of the Room Manager
                                    in order to use the room.</li></ul>
                                
                                <ul><li> Students that are not listed on "Students involved"
                                    section are not allowed on the reserved room.</li></ul>
                                
                                <ul><li> Regular rooms are automatically approved.</li></ul>
                                
                                <ul><li> Users can only reserve a room on a date that
                                    is within three months.</li></ul></p>
                            </div>
                        @endif
                    </div>
                    </div>

                    <div class="panel box box-primary">
                    <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseThree">
                        <h4 class="box-title text-info">Contact Information</h4>
                    </div>

                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body" style="margin:0 10px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>For Technical support:<br>
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