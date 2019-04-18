@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

		
			<form method="POST" action="{{ route('processaddroom') }}">
                        	@csrf

			<div class="form-group row">
                            <label for="room_id" class="col-md-4 col-form-label text-md-right">{{ __('ROOM ID') }}</label>

                            <div class="col-md-6">
                                <input id="room_id" type="text" class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" name="room_id" value="{{ old('room_id') }}" required autofocus>

                                @if ($errors->has('room_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('room_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


			<div class="form-group row">
                            <label for="room_desc" class="col-md-4 col-form-label text-md-right">{{ __('Room Description') }}</label>

                            <div class="col-md-6">
                                <input id="room_desc" type="text" class="form-control{{ $errors->has('room_desc') ? ' is-invalid' : '' }}" name="room_desc" value="{{ old('room_desc') }}" required autofocus>

                                @if ($errors->has('room_desc'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('room_desc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


			<div class="form-group row">
                            <label for="isSpecial" class="col-md-4 col-form-label text-md-right">{{ __('Special') }}</label>

                            <div class="col-md-6">
                                <input id="isSpecial" type="number" class="form-control{{ $errors->has('isSpecial') ? ' is-invalid' : '' }}" name="isSpecial" value="{{ old('isSpecial') }}" min="0" max="1" autofocus>

                                @if ($errors->has('isSpecial'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('isSpecial') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

			<div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

                          
                            </div>
                        </div>

			</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
