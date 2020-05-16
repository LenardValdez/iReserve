<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	//If the user rule is 0
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	//VALIDATE
    return [
        'room_id' => 'required|unique:rooms,room_id,NULL,id,deleted_at,NULL',
        'room_name' => 'max:50',
        'room_desc' => 'required',
        'isSpecial' => 'required|min:0|max:1'
	];
    }
}
