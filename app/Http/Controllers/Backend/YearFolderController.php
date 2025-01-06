<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Backend\MainFolder;
use App\Models\Backend\MonthFolder;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Crypt;
use File;
use Illuminate\Http\Request;
class YearFolderController extends Controller{
    public function index($main_f_id){
        $decrypt_main_f_id = Crypt::decrypt($main_f_id);
        $currentYear = Carbon::now()->format('Y')+1;
        $year_folder_name = range(2023, $currentYear);
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $main_folder_label = MainFolder::where('id', $decrypt_main_f_id)->first()->label;
            $year_folder_list = YearFolder::where('status', 1)->where('main_folder_id', $decrypt_main_f_id)->get();
            return view('backend.year_folder.index', compact('year_folder_list', 'main_folder_label', 'decrypt_main_f_id', 'year_folder_name'));
        }elseif(Auth::user()->role_id == 3){
            $main_folder_label = MainFolder::where('id', $decrypt_main_f_id)->first()->label;
            $employee = User::with('getEmployeeAndClient')->where('id', Auth::user()->id)->first();
            $clientIds = $employee->getEmployeeAndClient->pluck('client_id');  
            $main_folders = MainFolder::whereIn('client_id', $clientIds)->pluck('id')->toArray(); 
            if (in_array($decrypt_main_f_id, $main_folders)) {
                $year_folder_list = YearFolder::where('status', 1)->where('main_folder_id', $decrypt_main_f_id)->get();
                return view('backend.year_folder.index', compact('year_folder_list', 'main_folder_label', 'decrypt_main_f_id', 'year_folder_name'));
            }else{
                abort('404');
            } 
        }elseif(Auth::user()->role_id == 4){
            $main_folder_label = MainFolder::where('id', $decrypt_main_f_id)->first()->label;
            $check_m_folder = MainFolder::where('user_id', Auth::user()->id)->where('id', $decrypt_main_f_id)->where('status', 1)->exists();
            if($check_m_folder){
                $year_folder_list = YearFolder::where('status', 1)->where('main_folder_id', $decrypt_main_f_id)->get();
                return view('backend.year_folder.index', compact('year_folder_list', 'main_folder_label', 'decrypt_main_f_id', 'year_folder_name'));
            }else{
                abort('404');
            }   
        } 
        abort('404');
    }
    public function store(Request $request){
        $main_folder = MainFolder::where('id', $request->m_f_id)->first();
        $validate = $request->validate([
            "folder_name" => "required"
        ]); 
        $directoryPath = public_path('client_data/'.$main_folder->name.'/'.$request->folder_name); 
        if (!file_exists($directoryPath)){ 
           $year_folder =  YearFolder::create([
                "name" => $request->folder_name,
                "label" => $request->folder_name,
                "main_folder_id" => $request->m_f_id, 
            ]);
            File::makeDirectory($directoryPath, 0755, true); 
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            foreach($months as $month){
                MonthFolder::create([
                    "name" => $month,
                    "label" => $month,
                    "main_folder_id" => $request->m_f_id,
                    "year_folder_id" => $year_folder->id
                ]);
                $directoryPath = public_path('client_data/'.$main_folder->name.'/'.$year_folder->name.'/'.$month); 
                if(!file_exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0755, true); 
                }
            }
            return redirect()->back()->with("created", "Folder has been created.");
        }else{
            return redirect()->back()->with("already_exists", "This folder is already exists.");
        }
    }
}
