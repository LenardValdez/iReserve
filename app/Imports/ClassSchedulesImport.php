<?php

namespace App\Imports;

use Carbon\Carbon;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ClassSchedulesImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable;

    private $termNumber;
    private $termStartDate;
    private $termEndDate;

    public function __construct($termNumber, $termStartDate, $termEndDate)
    {
        $this->termNumber = $termNumber;
        $this->termStartDate = $termStartDate;
        $this->termEndDate = $termEndDate;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {
        return ClassSchedule::updateOrCreate([
            'subject_code' => $row['subject_code'],
            'user_id' => $row['user_id'],
            'room_id' => $row['room_number'],
            'section' => $row['section'],
            'stime_class' => Carbon::parse($row['start_time'])->format('H:i:s'),
            'etime_class' => Carbon::parse($row['end_time'])->format('H:i:s'),
            'day' => strtoupper($row['day']),
            'term_number' => $this->termNumber,
            'sdate_term' => Carbon::parse($this->termStartDate)->format('Y-m-d'),
            'edate_term' => Carbon::parse($this->termEndDate)->format('Y-m-d')
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            '*.user_id' => 'required|exists:users,user_id',
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
            ]
        ];
    }

    public function customValidationMessages()
    {
        return [
            'user_id.exists' => 'Specified user does not exist in the database.',
            'room_number.exists' => 'Room number entered not found.',
            'start_time.different' => 'Start time cannot be the same as the end time!',
            'end_time.different' => 'End time cannot be the same as the start time!',
            'day.in' => 'Day entered invalid! Choose only from M, T, W, TH, F, S.'
        ];
    }  
}
