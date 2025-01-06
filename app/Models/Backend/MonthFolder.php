<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthFolder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "name",
        "label",
        "main_folder_id",
        "year_folder_id",
        "status"
    ];

    public function getYearFolder(){
        return $this->belongsTo(MonthFolder::class, 'year_folder_id');
    }
}
