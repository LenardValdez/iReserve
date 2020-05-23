@foreach($forms as $form)
<div class="modal fade" id="reqInfo{{$form->form_id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Reservation Details</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Request ID</th>
                        <td>{{ sprintf("%07d",$form->form_id) }}</td>
                    </tr>
                    @if($isOverall)
                    <tr>
                        <th>User</th>
                        <td>@if($form->user->user_type > 2){{$form->user_id}}@endif {{$form->user->name}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Date Submitted</th>
                        <td>{{ Carbon::parse($form->created_at)->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Room Number</th>
                        <td>{{$form->room_id}} @if($form->room->room_name!=NULL){{$form->room->room_name}}@endif</td>
                    </tr>
                    <tr>
                        <th>People Involved</th>
                        <td>@if($form->users_involved!=NULL){{$form->users_involved}} @else N/A @endif</td>
                    </tr>
                    <tr>
                        <th>Reservation Period</th>
                        <td>{{ Carbon::parse($form->stime_res)->format('M d, Y h:i A') }} - {{ Carbon::parse($form->etime_res)->format('M d, Y h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Purpose</th>
                        <td>{{$form->purpose}}</td>
                    </tr>
                </table>
            </div>
            @if (Auth()->user()->roles == 0 or (Auth()->user()->roles == 1 && Auth()->user()->user_id == $form->user_id && $form->isCancelled == 0 && $form->isApproved != 2))
                <div class="modal-footer">
                    @if(Auth()->user()->roles == 0 && $isApproval)
                        <a type="button" href="{{ route('rejectrequest', $form->form_id) }}" class="btn btn-danger pull-left">Reject</a>
                        <a type="button" href="{{ route('approverequest', $form->form_id) }}" class="btn btn-success">Approve</a>
                    @elseif(Carbon::parse($form->etime_res)->isPast())
                        <button type="button" class="btn btn-danger" disabled>Cancel Reservation</button>
                    @else
                        <a type="button" class="btn btn-danger" data-target="#cancelModal{{ $form->form_id }}"  data-toggle="modal" data-dismiss="modal">Cancel Reservation</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@include('layouts.modals.cancelModal')
@endforeach