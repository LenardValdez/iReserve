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
            <p>Are you sure you want to delete? Please enter your password to confirm.</p>
            <div class="form-group" id="confirmPassword">
            <input type="password" class="form-control" placeholder="Enter password to confirm deletion" name="password">
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