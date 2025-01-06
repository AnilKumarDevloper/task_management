<?php

namespace App\Models\Backend;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        "ticket_number",
        "raised_by",
        "question",
        "file",
        "file_url",
        "resolution_date",
        "resolution_status",
        "original_file_name",
        "reminder_status",
        "reminder_count"
    ];

    public function getRaisedBy(){
        return $this->belongsTo(User::class, 'raised_by');
    }
}
