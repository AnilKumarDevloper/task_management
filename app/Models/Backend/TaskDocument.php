<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        "task_id",
        "file",
        "file_original_name",
        "file_path"
    ];
}
