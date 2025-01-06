<?php
namespace App\Models\Backend;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AuthorityMatrix extends Model{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "permission", 
        "permission_given_by",
        "status"
    ];
}
