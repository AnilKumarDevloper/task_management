<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Backend\Document;
use App\Models\Backend\EmployeeAndClient;
use App\Models\Backend\MainFolder;
use App\Models\Backend\MonthFolder;
use App\Models\Backend\Task;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
class ApiController extends Controller{
    public function getClientList(Request $request){
        try{
            $employee_id = $request->employee_id;
            $client_ids = EmployeeAndClient::where('user_id', $employee_id)->pluck('client_id')->toArray();
            $clients = User::whereIn('id', $client_ids)->get();   
            return response()->json([
                "status" => "success",
                "clients" => $clients
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => "error",
                "error" => $e->getMessage()
            ], 400);
        }
    }
    public function getYearFolderList(Request $request){
        try{
            $validate = $request->validate([
                "client_id" => ['required']
            ]);
            $client_id = $request->client_id;
            $main_folder_id = MainFolder::where('client_id', $client_id)->pluck('id');
            $year_folder_list = YearFolder::where('main_folder_id', $main_folder_id)->get();
            $lastRecordId = $year_folder_list->last()->id;
            $month_folders = MonthFolder::where('year_folder_id', $lastRecordId)->get();
            $current_year = Carbon::now()->format('Y');
            $current_month = Carbon::now()->format('F'); 
            return response()->json([
                "status" => "success",
                "year_folders" => $year_folder_list,
                "month_folders" => $month_folders,
                "current_year" => $current_year,
                "current_month" => $current_month
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }
    public function getMonthFolderList(Request $request){
        try{
            $validate = $request->validate([
                "year_folder_id" => ["required"]
            ]);
            $year_folder_id = $request->year_folder_id;
            $month_folders = MonthFolder::where('year_folder_id', $year_folder_id)->get();
            return response()->json([
                "status" => "success",
                "month_folders" => $month_folders
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ], 400);
        }
    }
    public function getDocumentList(Request $request){
        $validate = $request->validate([
            "month_folder" => ["required"]
        ]);
        try{    
            $document = Document::where('month_folder_id', $request->month_folder)->get();
            return response()->json([
                "status" => "success",
                "document_list" => $document
            ]); 
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ], 200);
        }
    }   
    public function getEmployee(Request $request){
        $validat = $request->validate([
            "client_id" => ["required"]
        ]);
        try{
            $employee = User::where('client_id', $request->client_id)->first();
            return response()->json([
                "status" => "success",
                "employee" => $employee
            ]);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }  
}
