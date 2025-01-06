<?php
namespace App\Models\Backend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AdditionalRightsComment extends Model{
    use HasFactory;
    protected $fillable =[
        "request_id",
        "user_id",
        "parent_id",
        "comment",
        "seen_status",
        "status"
    ];
    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
