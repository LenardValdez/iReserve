<?php

namespace App\Http\Controllers;

use Response;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Imports\ClassSchedulesImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

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
            return redirect()->back()->with('classErr', ["Error importing CSV!", $errorMessage]);
        }
        return redirect()->back()->with('roomAlert',["CSV import successful!", "Corresponding day and time periods will be blocked for reservations."]);
    }

    public function destroy(Request $request) {
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_schedules,class_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        if ($validator->errors()->has('password')) {
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            $class = ClassSchedule::where('class_id',$request->class_id)->first();
            $classCode = $class->subject_code . " " . $class->section;
            $class->delete();

            return Response::json(['success' => true, 'idRemoved' => $classCode]);
        }
    }

    public function download() {
        return Response::download(
            public_path()."/Class Schedule Import Template.xlsx", 
            'class_schedule_import_template.xlsx', 
            ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8"']
        );
    }
}
