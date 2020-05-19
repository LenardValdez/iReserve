<div class="modal fade" id="cancelModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Confirm Cancellation</h4>
            </div>
            <form role="form" id="cancelForm" method="POST" action="{{route('cancelrequest')}}">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to cancel? To confirm, kindly state your reason for recording purposes.</p>
                    <div class="form-group">
                    <input type="hidden" name="user_id" value="{{ Auth()->user()->user_id }}">
                    <input type="hidden" name="form_id" value="{{ $formId }}">
                    <input type="text" class="form-control" placeholder="Enter reason for cancellation" name="reason" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Revise</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>