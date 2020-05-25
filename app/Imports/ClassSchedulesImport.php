<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Division;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Row;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Validators\ValidationException as LaravelExcelException;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ClassSchedulesImport implements OnEachRow, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable; // provided trait that makes import classes importable without the need of the facade

    private $termNumber;
    private $termStartDate;
    private $termEndDate;
    private $rowCount = 0;

    public function __construct($termNumber, $termStartDate, $termEndDate)
    {
        $this->termNumber = $termNumber;
        $this->termStartDate = $termStartDate;
        $this->termEndDate = $termEndDate;
    }

    /**
     * Defines the chunk size for chunk reading (read the spreadsheet in chunks and keep the memory usage under control)
     *
     * @return int chunk size
     */ 
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * Imports the CSV to the ClassSchedule Eloquent model using updateOrCreate() in case of presence of duplicates
     * 
     * @param \Maatwebsite\Excel\Row $row
     * @return \Maatwebsite\Excel\Validators\ValidationException if timeslot error has been detected
     */
    public function onRow(Row $row)
    {
        $row = $row->toArray();
        $division_id = Division::where('division_name', $row['division'])->pluck('division_id')[0];

        //keeps track of the row number being traversed
        ++$this->rowCount;

        // checks if the row will overlap with an existing class schedule
        $similarTimeslot = ClassSchedule::where('room_id', $row['room_number'])
                                        ->where('stime_class', '<', Carbon::parse($row['end_time'])->format('H:i:s'))
                                        ->where('etime_class', '>', Carbon::parse($row['start_time'])->format('H:i:s'))
                                        ->where('day', strtoupper($row['day']))
                                        ->count();

        if($similarTimeslot > 0) {
            $errorMessage = "Overlapping timeslot detected in the CSV file/scheduler after checking availability of Room ".$row['room_number'].
            " for ".$row['subject_code']." ".$row['section'].". Please check your file and scheduler.";
            // return redirect()->back()->with('classErr', ["CSV Import Aborted!", $errorMessage]);
            $error = ['timeslot' => $errorMessage];
            $data = ['timeslot' => strtoupper($row['day'])." ".Carbon::parse($row['start_time'])->format('h:i A')." - ".Carbon::parse($row['end_time'])->format('h:i A')];
            $failures[] = new Failure($this->rowCount, 'timeslot', $error, $data);
            throw new LaravelExcelException(ValidationException::withMessages($error), $failures);
        }
        else {
            ClassSchedule::updateOrCreate([
                'subject_code' => $row['subject_code'],
                'user_id' => $row['user_id'],
                'room_id' => $row['room_number'],
                'section' => $row['section'],
                'stime_class' => Carbon::parse($row['start_time'])->format('H:i:s'),
                'etime_class' => Carbon::parse($row['end_time'])->format('H:i:s'),
                'day' => strtoupper($row['day']),
                'division_id' => $division_id,
                'term_number' => $this->termNumber,
                'sdate_term' => Carbon::parse($this->termStartDate)->format('Y-m-d'),
                'edate_term' => Carbon::parse($this->termEndDate)->format('Y-m-d')
            ]);
        }
    }

    /**
     * Indicates the rules that each row need to adhere to
     *
     * @return array with Laravel Validation rules to be returned
     */ 
    public function rules(): array
    {
        $divisions = Division::pluck('division_name')->toArray();

        return [
            'user_id' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('user_type', 2);
                })
            ],
            '*.user_id' => [
                'required',
                Rule::exists('users')->where(function ($query) {
                    $query->where('user_type', 2);
                })
            ],
            'room_number' => 'required|exists:rooms,room_id',
            '*.room_number' => 'required|exists:rooms,room_id',
            'start_time' => 'required|different:*.end_time',
            '*.start_time' => 'required|different:*.end_time',
            'end_time' => 'required|different:*.start_time',
            '*.end_time' => 'required|different:*.start_time',
            'day' => [
                'required',
                Rule::in(['M', 'm', 'T', 't', 'W', 'w', 'TH', 'th', 'Th', 'F', 'f', 'S', 's'])
            ],
            '*.day' => [
                'required',
                Rule::in(['M', 'm', 'T', 't', 'W', 'w', 'TH', 'th', 'Th', 'F', 'f', 'S', 's'])
            ],
            'division' => [
                'required',
                Rule::in($divisions)
            ],
            '*.division' => [
                'required',
                Rule::in($divisions)
            ]
        ];
    }

    /**
     * Specifies custom messages for each failure
     *
     * @return array with custom messages
     */ 
    public function customValidationMessages()
    {
        return [
            'user_id.exists' => 'Specified user either does not exist in the database or is not assigned as part of the faculty.',
            'room_number.exists' => 'Room number entered not found.',
            'start_time.different' => 'Start time cannot be the same as the end time!',
            'end_time.different' => 'End time cannot be the same as the start time!',
            'day.in' => 'Day entered invalid! Choose only from M, T, W, TH, F, S.',
            'division.in' => 'Division entered invalid! Values should be either Faculty, College, or Senior High.'
        ];
    }  
}
