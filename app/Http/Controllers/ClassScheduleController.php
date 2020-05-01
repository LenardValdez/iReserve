<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\ClassSchedulesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'term_number' => 'required|between:1,3',
            'sdate_term' => 'required|date',
            'edate_term' => 'required|date',
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        try {
            Excel::import(new ClassSchedulesImport($request->term_number, $request->sdate_term, $request->edate_term), $request->file('csv_file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Problems encountered:\n";
            foreach ($failures as $failure) {
                // $failure->row(); // row that went wrong
                // $failure->attribute(); // either heading key (if using heading row concern) or column index
                // $failure->errors(); // Actual error messages from Laravel validator
                // $failure->values(); // The values of the row that has failed.
                $errorMessage .= "- Row " .$failure->row(). ": [" .$failure->attribute(). "] " .implode (' ', $failure->errors()). 
                " (Given value: " .$failure->values()[$failure->attribute()]. ")\n";
            }
            return redirect()->back()->with('classErr', $errorMessage);
        }
        return redirect()->back()->with('roomAlert',"Classes have been successfully added to the database!");
    }
}
