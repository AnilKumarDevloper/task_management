<?php
namespace App\Models\Backend;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Document extends Model{
    use HasFactory;
    protected $fillable = [
        "title",
        "doc_file",
        "doc_path",
        "disk",
        "main_folder_id",
        "year_folder_id",
        "month_folder_id",
        "uploaded_by",
        "status"
    ];
}
