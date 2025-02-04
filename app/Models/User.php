<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Backend\AuthorityMatrix;
use App\Models\Backend\CompanyDetail;
use App\Models\Backend\EmployeeAndClient;
use App\Models\Backend\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'created_by',
        'status',
        'phone',
        'clients',
        'client_id',
        'profile'
    ];

    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'clients' => 'array'
    ];

    public function getCompanyDetail(){
        return $this->hasOne(CompanyDetail::class, 'user_id');
    }

  
    public function getEmployeeAndClient(){
        return $this->hasMany(EmployeeAndClient::class, 'user_id')->with('getClient');
    }

    public function getClient(){
        return $this->belongsTo(User::class, 'client_id');
    }

    public function getAuthorityMatrix(){
        return $this->hasMany(AuthorityMatrix::class, 'user_id');
    }

    public function getEmployeeTask(){
        return $this->hasMany(Task::class, 'assigned_to');
    }
     

    
}
