<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "doc_file",
        "doc_path",
        "document_id",
        "assigned_by",
        "assigned_to",
        "start_date",
        "start_time",
        "end_date",
        "end_time",
        "main_folder_id",
        "year_folder_id",
        "month_folder_id",
        "current_status",
        "status",
        "running_status",  //0=ended, 1=started, 2=not started
        "client_id",
        "year",
        "month",
        "description",
        "title",
        "compliance_date",
        "due_date",
        "amended_by",
        "reminder_status",
        "reminder_count"
    ];

    public function getEmployee(){
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function getDocument(){
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function getClient(){
        return $this->belongsTo(User::class, 'client_id');
    }

    public function getAssignedBy(){
        return $this->belongsTo(User::class, 'assigned_by');
    }
    public function getAmendedBy(){
        return $this->belongsTo(User::class, 'amended_by');
    }

    public function getTaskDocument(){
        return $this->hasMany(TaskDocument::class, 'task_id');
    }
}
