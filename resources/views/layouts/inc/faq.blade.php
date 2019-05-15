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
                        <h4 class="box-title text-info">How to Reserve A Room</h4>
                    </div>

                    <div id="collapseOne" class="panel-collapse collapse in">
                        @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                            </div>
                        @else <!--User FAQ-->
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
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
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                            </div>
                        @else <!--User FAQ-->
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                            </div>
                        @endif
                    </div>
                    </div>

                    <div class="panel box box-primary">
                    <div class="box-header with-border" data-toggle="collapse" data-parent="#faq" href="#collapseThree">
                        <h4 class="box-title text-info">Contact Information</h4>
                    </div>

                    <div id="collapseThree" class="panel-collapse collapse">
                            @if (Auth()->user()->roles == 0) <!--Admin FAQ-->
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                            </div>
                        @else <!--User FAQ-->
                            <div class="box-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>