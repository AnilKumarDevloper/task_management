<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\MainFolder;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
class MainFolderController extends Controller{
    public function index(){ 
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $main_folder_list = MainFolder::where('status', 1)->get();
        }elseif(Auth::user()->role_id == 3){
            $employee = User::with('getEmployeeAndClient')
            ->where('id', Auth::user()->id)
            ->first();
            $clientIds = $employee->getEmployeeAndClient->pluck('client_id');
            $main_folder_list = MainFolder::whereIn('client_id', $clientIds)->where('status', 1)->get();
        }elseif(Auth::user()->role_id == 4){
            $main_folder_list = MainFolder::where('client_id', Auth::user()->id)->where('status', 1)->get();
        }
        return view('backend.main_folder.index', compact('main_folder_list'));
    }
}
