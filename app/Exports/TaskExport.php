<?php

namespace App\Exports;

use App\Models\Backend\Task;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $client_id, $month, $year;
    public function __construct($client_id, $year, $month){
        $this->client_id = $client_id;
        $this->month = $month;
        $this->year = $year;
    }
    public function collection(){
    $tasks = Task::select( 
        'title',
        'doc_file',
        'doc_path',
        'description',
        'document_id',
        'assigned_by',
        'assigned_to',
        'client_id',
        'year',
        'month',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'compliance_date',
        'due_date',
        'main_folder_id',
        'year_folder_id',
        'month_folder_id',
        'current_status',
        'amended_by',
        'reminder_status',
        'reminder_count',
        'running_status',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    )
    ->where('client_id', $this->client_id)
    ->where('year', $this->year) 
    ->get();

    // Add serial number at the first position
    $serialNumber = 1;
    return $tasks->map(function ($task) use (&$serialNumber) {
        return collect([
            'serial_number' => $serialNumber++, // Add serial number first
        ])->merge($task); // Merge existing columns
    });
}


}
