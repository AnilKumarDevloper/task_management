<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Backend\MainFolder;
use App\Models\Backend\MonthFolder;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
class MonthFolderController extends Controller{
    public function index($main_f_id, $year_f_id){
        $decrypt_main_f_id = Crypt::decrypt($main_f_id);
        $decrypt_year_f_id = Crypt::decrypt($year_f_id);
        $year_f = YearFolder::where('id', $decrypt_year_f_id)->first();
        $main_f = MainFolder::where('id', $decrypt_main_f_id)->first();  
        $month_folder_list = MonthFolder::where('year_folder_id', $decrypt_year_f_id)->get();
        return view('backend.month_folder.index', compact('month_folder_list',
         'year_f', 'main_f'));
    }
}
