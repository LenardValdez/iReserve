@foreach($forms as $form)
@if($form->isApproved != 2 && $form->isCancelled != 1 && !Carbon::parse($form->etime_res)->isPast())
<div class="modal fade" id="cancelModal{{ $form->form_id }}">
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
                    <p>Are you sure you want to cancel form #{{ sprintf("%07d",$form->form_id) }}? To confirm, kindly state your reason for recording purposes.</p>
                    <div class="form-group{{ ($errors->cancel->has('user_id') || $errors->cancel->has('form_id') || $errors->cancel->has('reason')) ? ' has-error' : '' }}">
                        <input type="hidden" name="user_id" value="{{ Auth()->user()->user_id }}">
                        <input type="hidden" name="form_id" value="{{ $form->form_id }}">
                        <input type="text" class="form-control" placeholder="Enter reason for cancellation" name="reason" value="{{ old('reason') }}" required>
                        @if ($errors->cancel->has('user_id') || $errors->cancel->has('form_id') || $errors->cancel->has('reason'))
                            <span class="help-block" role="alert">
                            @if($errors->cancel->has('user_id'))
                                {{ $errors->cancel->first('user_id') }}
                            @elseif($errors->cancel->has('form_id'))
                                {{ $errors->cancel->first('form_id') }}
                            @else
                                {{ $errors->cancel->first('reason') }}
                            @endif
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Back</button>
                    <button type="submit" class="btn btn-danger">Continue Cancellation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach