<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CancelReservation extends FormRequest
{
    protected $errorBag = "cancel";
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
            'user_id' => [
                'required',
                Rule::in([Auth()->user()->user_id, 'admin'])
            ],
            'form_id' => 'required|exists:reg_forms,form_id',
            'reason' => 'required|max:140'
        ];
    }
}
