<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\MainFolder;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Illuminate\Http\Request;

class FolderPermissionController extends Controller{
    public function create($employee_id, $client_id){
        $employee = User::where('id', $employee_id)->first();
        $client = User::where('id', $client_id)->first();
        $main_folder = MainFolder::where('client_id', $client->id)->first();
        $year_folder = YearFolder::with(['getMonthFolder'])->where('main_folder_id', $main_folder->id)->get();   
        return view('backend.folder_permission.create', [$employee_id, $client_id]);
    }
    public function sendFolderPermissionPage(Request $request){
        $validate = $request->validate([
            "client" => ["required"],
            "employee_id" => ["required"]
        ]);  
      return redirect()->route('backend.folder_permission.create', [$request->employee_id, $request->client]);
    }
}
