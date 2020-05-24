<?php

namespace App\Http\Controllers;

use Response;
use App\ClassSchedule;
use Illuminate\Http\Request;
use App\Http\Requests\InsertSchedule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Imports\ClassSchedulesImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Validators\ValidationException;

class ClassScheduleController extends Controller
{
    /**
     * Stores the csv imported to the class schedule database
     *
     * @param  \App\Http\Requests\InsertSchedule $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertSchedule $request) {
        // validates the CSV uploaded
        $validatedRequest = $request->validated();
        $requiredHeadings = ["subject_code", "user_id", "room_number", "section", "start_time", "end_time", "day", "division"];
        $headingRows = (new HeadingRowImport)->toArray($validatedRequest['csv_file']);
        $headingDifferences = (array_diff($requiredHeadings, $headingRows[0][0])) ? implode(", ", array_diff($requiredHeadings, $headingRows[0][0])) : false;

        if ((count($requiredHeadings) == count($headingRows[0][0])) && !$headingDifferences) {
            try {
                Excel::import(new ClassSchedulesImport($validatedRequest['term_number'], $validatedRequest['sdate_term'], $validatedRequest['edate_term']), $validatedRequest['csv_file']);
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
        else {
            return redirect()->back()->with('classErr', ["Error importing CSV!", "Column name/count requirement was not met. Missing column/s: ".$headingDifferences]);
        }
    }

    /**
     * Deletes the class schedule selected
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        // creates a custom validator to check if the password entered is correct
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_schedules,class_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        // returns errors to the AJAX request if password entered is incorrect
        if ($validator->errors()->has('password')) {
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            $class = ClassSchedule::where('class_id',$request->class_id)->first();
            $classCode = $class->subject_code . " " . $class->section;
            $class->delete();

            // returns success boolean variable to the AJAX request along with the room number removed for the display message
            return Response::json(['success' => true, 'idRemoved' => $classCode]);
        }
    }

    /**
     * Returns the CSV import template in XLSX file for downloading
     *
     * @return \Illuminate\Http\Response
     */
    public function download() {
        return Response::download(
            public_path()."/Class Schedule Import Template.xlsx", 
            'class_schedule_import_template.xlsx', 
            ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8"']
        );
    }
}
