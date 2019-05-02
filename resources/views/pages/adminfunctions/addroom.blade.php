<!--ADD NEW ROOM-->
<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Room</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form role="form" id="roomDataForm">
              <div class="form-group">
                <label for="roomNumber">Room Number: </label>
                <input type="text" class="form-control" name="formName" placeholder="Enter room number" required>
              </div>
              <div class="form-group">
                <label for="roomName">Room Name: </label>
                <input type="text" class="form-control" name="formName" placeholder="Enter room name">
              </div>
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1">Special Room
                  </label>
                </div>
              </div>
              <button type="submit" data-toggle="modal" data-target="#successRoomModal" data-dismiss="modal" class="btn btn-primary pull-right">Add</button>
          </form>
        </div>
      </div>

      <!--DELETE ROOM-->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Delete Existing Room</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form role="form" id="roomDataForm">
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
            <button type="button" data-target="#confirmRoomDeletion" data-toggle="modal" class="btn btn-danger pull-right">Delete</button>

            <div class="modal fade" id="confirmRoomDeletion">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Room Deletion</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Are you sure you want to delete this room? You cannot undo this action.</h4>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Revise</button>
                      <button type="submit" class="btn btn-danger" data-target="#successRoomModal" data-dismiss="modal" data-toggle="modal">Delete</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div><!--END OF BOX-BODY-->
      </div><!--END OF CONTENT BOX-->