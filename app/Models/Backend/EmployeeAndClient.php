<?php
namespace App\Models\Backend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EmployeeAndClient extends Model{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "client_id",
        "employee_id",
        "status",
    ];
    public function getClient(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
