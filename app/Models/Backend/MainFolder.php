<?php
namespace App\Models\Backend;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MainFolder extends Model{
    use HasFactory;
    protected $fillable = [
        "name",
        "client_id",
        "status",
        "label"
    ];
}
