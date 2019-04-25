<div class="row">
    <div class="col-md-2">
        <br>
        <!--ADD ROOM BUTTON-->
        <button type="submit" class="btn btn-default btn-circle" data-target="#addRoomModal" data-toggle="modal">
            <i class="fa fa-plus-circle"></i>
        </button>

        <!--ADD ROOM MODAL-->
        <div class="modal fade" id="addRoomModal">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Add New Room</h4>
                    </div>
                <div class="modal-body">
                    <form role="form" id="roomDataForm">
                        <div class="form-group">
                            <label for="roomNumber">Room Number: </label>
                            <input type="text" class="form-control" name="formName" placeholder="Enter room number" required>
                        </div>
                    <div class="form-group">
                        <label for="roomName">Room Name: </label>
                        <input type="text" class="form-control" name="formName" placeholder="Enter room name">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#successRoomModal" data-dismiss="modal">Add</button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                </div>
                </div>
            </div>
        </div>
    </div> <!--END OF COLUMN-->
</div> <!--END OF ROW-->