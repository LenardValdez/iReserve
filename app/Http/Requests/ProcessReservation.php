<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessReservation extends FormRequest
{
    protected $errorBag = "process";
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
            'form_id' => 'required|exists:reg_forms,form_id,isApproved,0'
        ];
    }

    /**
     * Override the all() function for this request object to apply validation rules to the URL parameter
     *
     * @param keys reflect the new $keys argument
     * @return array
     */
    public function all($keys = null) 
    {
        $request = parent::all($keys);
        $request['form_id'] = $this->route('id');
        return $request;
    }
}
