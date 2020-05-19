<div class="modal fade" id="csvFormatInfo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Correct CSV Format</h4>
            </div>
            <div class="modal-body">
                <p>
                    In order to avoid errors when importing class schedules, 
                    please make sure the following conditions are being followed in your sheet:
                </p>
                <dl class="dl-horizontal">
                    <dt>Subject Code</dt>
                    <dd>e.g. CONWORLD, PURPCOMM, CSELEC04</dd>
                    <dt>User ID</dt>
                    <dd>must be part of the faculty<br>e.g. juan.delacruz</dd>
                    <dt>Room Number</dt>
                    <dd>e.g. 901, 1005, GFWEST</dd>
                    <dt>Section</dt>
                    <dd>e.g. SEG21, ABM12</dd>
                    <dt>Start Time</dt>
                    <dd>must be within campus hours (7:30AM - 9:30PM)</dd>
                    <dt>End Time</dt>
                    <dd>must be within campus hours (7:30AM - 9:30PM)</dd>
                    <dt>Day</dt>
                    <dd>M, T, W, F, S<br>classes of more than once a week must be declared separately</dd>
                    <dt>Division</dt>
                    <dd>College or Senior High</dd>
                </dl>
                <p>Sample content (file must be exported as CSV): </p>
                <img src="img/sampleCsv.png" class="img-responsive" alt="Table Format Sample">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <a type="button" href="{{ route('template') }}" class="btn btn-primary">Download Excel Template</a>
            </div>
        </div>
    </div>
</div>