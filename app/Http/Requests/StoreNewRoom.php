<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewRoom extends FormRequest
{
    protected $errorBag = "newRoom";
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
            'room_id' => 'required|unique:rooms,room_id,NULL,id,deleted_at,NULL', // ignores soft-deleted entries to allow restoration
            'room_name' => 'max:50',
            'room_desc' => 'required|exists:rooms,room_desc',
            'isSpecial' => 'required|min:0|max:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'room_id' => 'Room number entered is already in the system.',
            'room_name' => 'Room name can only be up to 50 characters.',
            'room_desc' => 'Invalid floor number.',
            'isSpecial' => 'Invalid room category.'
        ];
    }
}
