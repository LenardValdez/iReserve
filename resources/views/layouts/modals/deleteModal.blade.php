<div class="modal fade" id="{{ $deleteModalId }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">{{ $deleteActionTitle }}</h4>
        </div>
        <div class="modal-body">
            @if($isRoom)
            <div class="alert alert-warning">
                <h4><i class="icon fa fa-warning"></i> Room Deletion Warning</h4>
                All upcoming reservations for this room will be automatically cancelled. 
                For existing class schedules, please make sure that room reassignments have already
                been made by deleting old class entries and importing new timeslots before performing this action.
            </div>
            <p>Are you sure you want to delete this room? Please enter your password to confirm.</p>
            @else
            <p>Are you sure you want to delete this class schedule? Please enter your password to confirm.</p>
            @endif
            <div class="form-group" id="confirmPassword">
            <input type="password" class="form-control" placeholder="Enter password to confirm deletion" name="password" autocomplete="current-password">
            <span id="passwordHelpBlock" class="help-block"></span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Revise</button>
            <button type="submit" class="btn btn-danger" onclick="$('{{ $formId }}').submit()">Delete</button>
        </div>
        </div>
    </div>
</div>