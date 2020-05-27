<!--ADD NEW ROOM-->
<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Room</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form role="form" id="roomDataForm" method="POST" action="{{ route('processaddroom') }}">
            @csrf
            <div class="form-group{{ $errors->newRoom->has('room_id') ? ' has-error' : '' }}">
                <label for="room_id">Room Number: <span class="text-danger">*</span></label>
                <input type="text" class="form-control{{ $errors->newRoom->has('room_id') ? ' has-error' : '' }}" placeholder="Enter room number" id="newroom_id" name="room_id" value="{{ old('room_id') }}" required>
                @if ($errors->newRoom->has('room_id'))
                  <span class="help-block" role="alert">
                    {{ $errors->newRoom->first('room_id') }}
                  </span>
                @endif
              </div>
              <div class="form-group{{ $errors->newRoom->has('room_name') ? ' has-error' : '' }}">
                <label for="room_name">Room Name: </label>
                <input type="text" class="form-control" placeholder="Enter room name (ex.: Chemistry Lab)" id="newroom_name" name="room_name" value="{{ old('room_name') }}">
                @if ($errors->newRoom->has('room_name'))
                <span class="help-block" role="alert">
                  {{ $errors->newRoom->first('room_name') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="room_desc">Floor: <span class="text-danger">*</span></label>
                <select id="room_desc" class="form-control{{ $errors->newRoom->has('room_desc') ? ' has-error' : '' }}" name="room_desc" value="{{ old('room_desc') }}" required>
                  <option selected disabled>Select floor</option>
                  <option value="6th Floor">6th Floor</option>
                  <option value="7th Floor">7th Floor</option>
                  <option value="8th Floor">8th Floor</option>
                  <option value="9th Floor">9th Floor</option>
                  <option value="10th Floor">10th Floor</option>
                  <option value="10th Floor">12th Floor</option>
                  <option value="Lower Penthouse">Lower Penthouse</option>
                  <option value="Upper Penthouse">Upper Penthouse</option>
                  <option value="Drawing Room 10th Floor">Drawing Room 10th Floor</option>
                  <option value="Ground Floor">Ground Floor</option>
                  <option value="Others">Others</option>
                </select>
                @if ($errors->newRoom->has('room_desc'))
                <span class="help-block" role="alert">
                  {{ $errors->newRoom->first('room_desc') }}
                </span>
                @endif
              </div>
              <div class="form-group">
                <label for="isSpecial">Category: <span class="text-danger">*</span></label>
                  <select class="form-control{{ $errors->newRoom->has('isSpecial') ? ' has-error' : '' }}" id="isSpecial" name="isSpecial" value="{{ old('isSpecial') }}"required>
                    <option value="" selected disabled>Select room category</option>
                    <option value="0">Ordinary Room</option>
                    <option value="1">Special Room</option>
                  </select>
                    @if ($errors->newRoom->has('isSpecial'))
                      <span class="help-block" role="alert">
                        {{ $errors->newRoom->first('isSpecial') }}
                      </span>
                    @endif
              </div>
              <p class="text-red pull-left"><span class="text-danger">*</span> items are required</p>
              <button type="submit" id="addRoomBtn" class="btn btn-primary pull-right">Add</button>
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
          <form role="form" id="roomModifyForm" method="POST" action="{{ route('processdelroom') }}">
            @csrf
            <div class="form-group{{ $errors->has('room_id') ? ' has-error' : '' }}">
              <label>Room Number: <span class="text-danger">*</span></label>
              <select class="form-control" id="deleteRoomId" name="room_id" required>
                <option value="" selected disabled>Select a room to be deleted</option>
                @foreach ($descriptions as $description)
                  <optgroup label="{{$description}}">
                    @foreach ($rooms as $room)
                      @if ($description == $room->room_desc)
                      <option value="{{$room->room_id}}">
                        @if (isset($room->room_name))
                          {{$room->room_id}} ({{$room->room_name}})
                        @else
                          {{$room->room_id}}
                        @endif
                      </option>
                      @endif
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @if ($errors->has('room_id'))
                <span class="help-block" role="alert">
                  {{ $errors->first('room_id') }}
                </span>
              @endif
            </div>
            <p class="text-red pull-left"><span class="text-danger">*</span> items are required</p>
            <button type="button" id="delRoomBtn" data-target="#confirmRoomDeletion" data-toggle="modal" class="btn btn-danger pull-right">Delete</button>
            @include('layouts.modals.deleteModal', ['deleteModalId' => 'confirmRoomDeletion', 'deleteActionTitle' => 'Room Deletion Confirmation', 'formId' => '#roomModifyForm', 'isRoom' => true])
          </form>
        </div><!--END OF BOX-BODY-->
      </div><!--END OF CONTENT BOX-->