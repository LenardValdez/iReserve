<!--ADD SCHEDULE-->
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Insert Class Schedule</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
        <form role="form" id="scheduleDataForm" method="POST" action="">
            @csrf
            <div class="row gutter-10">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="termNumber">Term: </label>
                        <select class="form-control" name="termNumber">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="form-group">
                        <label for="termPeriod">Term Period: </label>
                        <div class="input-group date">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar-o"></i>
                            </span>
                            <input type="text" class="form-control termPeriod" id="termPeriod" required>
                            <input type="hidden" name="sdate_term">
                            <input type="hidden" name="edate_term">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="csvFile">CSV File: </label>
                <input type="file" id="csvFile" name="csvFile">
                <p class="text-primary">What should be the format?</p>
            </div>
            <button type="submit" id="insertScheduleBtn" class="btn btn-primary pull-right">{{ __('Insert') }}</button>
        </form>
    </div>
  </div>

  <!--DELETE SCHEDULE-->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Delete Class Schedule</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form role="form" id="roomIdDelForm" method="POST" action="{{ route('processdelroom') }}">
        @csrf
        <div class="form-group{{ $errors->has('delroom_id') ? ' has-error' : '' }}">
          <label>Select Entry: </label>
          <select class="form-control" id="delroom_id" name="room_id" required>
            <option value="" selected disabled>Select a schedule to be deleted</option>
            @foreach ($descriptions as $description)
              <optgroup label="{{$description}}">
                @foreach ($rooms as $room)
                  @if ($description == $room->room_desc)
                    <option value="{{$room->room_id}}">{{$room->room_id}}</option>
                  @endif
                @endforeach
              </optgroup>
            @endforeach
          </select>
        </div>
        <button type="button" id="delAllScheduleBtn" data-target="#confirmRoomDeletion" data-toggle="modal" class="btn btn-default">Delete All</button>
        <button type="button" id="delScheduleBtn" data-target="#confirmRoomDeletion" data-toggle="modal" class="btn btn-danger pull-right">Delete</button>

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
                  <button type="submit" class="btn btn-danger" onclick="$('#roomIdDelForm').submit()">Delete</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div><!--END OF BOX-BODY-->
  </div><!--END OF CONTENT BOX-->