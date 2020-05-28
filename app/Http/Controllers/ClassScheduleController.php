<?php

namespace App\Http\Controllers;

use Response;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        Log::info('Request to store class schedule received from admin.');
        // validates the CSV uploaded
        $validatedRequest = $request->validated();
        Log::info('Initial request validation passed.');
        // validates the column names of the CSV uploaded
        $requiredHeadings = ["subject_code", "user_id", "room_number", "section", "start_time", "end_time", "day", "division"];
        $headingRows = (new HeadingRowImport)->toArray($validatedRequest['csv_file']);
        $headingDifferences = (array_diff($requiredHeadings, $headingRows[0][0])) ? implode(", ", array_diff($requiredHeadings, $headingRows[0][0])) : false;

        // checks if column count of the CSV uploaded matches the requirement and if all the required column names are present
        if ((count($requiredHeadings) == count($headingRows[0][0])) && !$headingDifferences) {
            try {
                Excel::import(new ClassSchedulesImport($validatedRequest['term_number'], $validatedRequest['sdate_term'], $validatedRequest['edate_term']), $validatedRequest['csv_file']);
                Log::info('CSV import sequence started. Filename: '.$validatedRequest['csv_file']);
            } catch (ValidationException $e) {
                Log::notice('CSV Row validation detected conflict/s in '.$validatedRequest['csv_file'].'. Action aborted.');
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
            Log::info('CSV import success. Stored to database.');
            return redirect()->back()->with('roomAlert',["CSV import successful!", "Corresponding day and time periods will be blocked for reservations."]);
        }
        else {
            Log::notice('CSV Column validation detected failure/s in '.$validatedRequest['csv_file'].'. Action aborted.');
            $errorMessage = ($headingDifferences) 
            ? "Column count and name requirements were not met. Number of Rows Provided: ".count($headingRows[0][0])."/".count($requiredHeadings).". Missing column/s: ".$headingDifferences 
            : "Column count requirement was not met. Number of Rows Provided: ".count($headingRows[0][0])."/".count($requiredHeadings);

            return redirect()->back()->with('classErr', ["Error importing CSV!", $errorMessage]);
        }
    }

    /**
     * Deletes the class schedule selected
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        Log::info('Request to delete class schedule received from admin.');
        // creates a custom validator to check if the password entered is correct
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        Log::info('Validating admin request to delete schedule for '.$request->input('subject_code').' '.$request->input('section').'.');
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:class_schedules,class_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        // returns errors to the AJAX request if password entered is incorrect
        if ($validator->errors()->has('password')) {
            Log::notice('Validation detected failure. Sending response to AJAX call.');
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            Log::info('Initial request validation passed.');
            $class = ClassSchedule::where('class_id',$request->class_id)->first();
            $classCode = $class->subject_code . " " . $class->section;
            $class->delete();
            Log::notice('Class deletion success. Sending response to AJAX call.');
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
        Log::info('Request to download CSV template received from '.Auth()->user()->user_id.'.');
        Log::info('Returning response to download XLSX file.');
        return Response::download(
            public_path()."/Class Schedule Import Template.xlsx", 
            'class_schedule_import_template.xlsx', 
            ['Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8"']
        );
    }
}
