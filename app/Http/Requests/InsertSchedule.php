<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsertSchedule extends FormRequest
{
    protected $errorBag = "insertSchedule";
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
            'term_number' => 'required|between:1,3',
            'sdate_term' => 'required|date|different:edate_term',
            'edate_term' => 'required|date|after:sdate_term',
            'csv_file' => 'required|mimes:csv,txt'
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
            'term_number' => 'term number',
            'sdate_term' => 'start date of term',
            'edate_term' => 'end date of term',
            'csv_file' => 'CSV file'
        ];
    }
}
