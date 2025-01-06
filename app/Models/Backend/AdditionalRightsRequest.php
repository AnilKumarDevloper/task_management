<?php
namespace App\Models\Backend;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AdditionalRightsRequest extends Model{
    use HasFactory;
    protected $fillable = [
        "request_number",
        "raised_by",
        "reason",
        "file",
        "original_file_name",
        "file_url",
        "resolution_date",
        "resolution_status",
        "status"
    ];
    public function getRaisedBy(){
        return $this->belongsTo(User::class, 'raised_by');
    }
}
