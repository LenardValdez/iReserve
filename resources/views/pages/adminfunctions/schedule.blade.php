<!--ADD SCHEDULE-->
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Insert Class Schedule</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
        <form role="form" id="scheduleDataForm" method="POST" action="{{ route('insertschedule') }}" enctype="multipart/form-data">
            @csrf
            <div class="row gutter-10">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="term_number">Term: <span class="text-danger">*</span></label>
                        <select class="form-control" name="term_number">
                            <option value=1>1</option>
                            <option value=2>2</option>
                            <option value=3>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="form-group">
                        <label for="termPeriod">Term Period: <span class="text-danger">*</span></label>
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
                <label for="csv_file">CSV File: <span class="text-danger">*</span></label>
                <input type="file" id="csvFile" name="csv_file" required>
                <p class="text-primary">What should be the format?</p>
            </div>
            <p class="text-red pull-left"><span class="text-danger">*</span> items are required</p>
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
    <form role="form" id="deleteScheduleForm" method="POST" action="{{ route('deleteschedule') }}">
        @csrf
        <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
          <label>Select Entry: <span class="text-danger">*</span></label>
          <select class="form-control" id="class_id" name="class_id" required>
            @if($classSchedules->isEmpty())
              <option value="" selected disabled>No entries available</option>
            @else
              <option value="" selected disabled>Select a schedule to be deleted</option>
              @foreach ($classrooms as $classroom)
                <optgroup label="{{$classroom}}">
                  @foreach ($classSchedules as $schedule)
                    @if ($classroom == $schedule->room_id)
                      <option value="{{$schedule->class_id}}">
                        {{$schedule->subject_code}} {{$schedule->section}} | {{$schedule->day}} {{Carbon::parse($schedule->stime_class)->format('h:i A') }}-{{Carbon::parse($schedule->etime_class)->format('h:i A') }}
                      </option>
                    @endif
                  @endforeach
                </optgroup>
              @endforeach
            @endif
          </select>
        </div>
        <p class="text-red pull-left"><span class="text-danger">*</span> items are required</p>
        <button type="button" id="delScheduleBtn" data-target="#confirmScheduleDeletion" data-toggle="modal" class="btn btn-danger pull-right">Delete</button>
        @include('layouts.modals.deleteModal', ['deleteModalId' => 'confirmScheduleDeletion', 'deleteActionTitle' => 'Schedule Deletion Confirmation', 'formId' => '#deleteScheduleForm'])
      </form>
    </div><!--END OF BOX-BODY-->
  </div><!--END OF CONTENT BOX-->