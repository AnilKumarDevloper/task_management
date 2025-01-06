<?php
namespace App\Models\Backend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DocumentComment extends Model{
    use HasFactory;
    protected $fillable = [
        "task_id",
        "document_id",
        "user_id",
        "parent_id",
        "comment",
        "publish_status",
        "status"
    ];
    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function getReplys(){
        return $this->hasMany(DocumentComment::class, 'parent_id');
    }
}
