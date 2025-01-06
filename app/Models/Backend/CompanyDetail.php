<?php
namespace App\Models\Backend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CompanyDetail extends Model{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "name",
        "phone",
        "email",
        "address",
        "logo",
        "logo_url",
        "logo_original_name",
        "status",
    ];
    public function GetUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

