<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearFolder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "name",
        "label",
        "main_folder_id",
        "status"
    ];

    public function getMonthFolder(){
        return $this->hasMany(MonthFolder::class, 'year_folder_id');
    }
}
