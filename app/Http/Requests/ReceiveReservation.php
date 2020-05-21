<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiveReservation extends FormRequest
{
    protected $errorBag = "receive";
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'room_id' => 'required|exists:rooms,room_id',
            'users_involved' => 'nullable',
            'stime_res' => 'required|date_format:Y-m-d H:i:s|after:yesterday',
            'etime_res' => 'required|date_format:Y-m-d H:i:s|different:stime_res',
            'purpose' => 'required|max:255'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user_id' => 'user ID',
            'room_id' => 'room number',
            'users_involved' => 'users involved',
            'stime_res' => 'start date and time',
            'etime_res' => 'end date and time',
            'purpose' => 'purpose'
        ];
    }
}
