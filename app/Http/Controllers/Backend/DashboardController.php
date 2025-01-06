<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
class DashboardController extends Controller{
    public function Dashboard(){
        $recent_tasks = Task::with('getEmployee')->where('status', 1); 
        $all_task_count = Task::where('status', 1);
        $new_task_count = Task::where('status', 1)->where('current_status', 'new');
        $inprocess_task_count = Task::where('status', 1)->where('current_status', 'in process');
        $complete_task_count = Task::where('status', 1)->where('current_status', 'completed');
        if(Auth::user()->role_id == 3){
            $all_task_count =  $all_task_count->where('assigned_to', Auth::user()->id);
            $new_task_count =  $new_task_count->where('assigned_to', Auth::user()->id);
            $inprocess_task_count =  $inprocess_task_count->where('assigned_to', Auth::user()->id);
            $complete_task_count =  $complete_task_count->where('assigned_to', Auth::user()->id);
            $recent_tasks =  $recent_tasks->where('assigned_to', Auth::user()->id);
        }
        if(Auth::user()->role_id == 4){
            $all_task_count =  $all_task_count->where('client_id', Auth::user()->id);
            $new_task_count =  $new_task_count->where('client_id', Auth::user()->id);
            $inprocess_task_count =  $inprocess_task_count->where('client_id', Auth::user()->id);
            $complete_task_count =  $complete_task_count->where('client_id', Auth::user()->id);
            $recent_tasks =  $recent_tasks->where('client_id', Auth::user()->id);
        } 
        $all_task_count = $all_task_count->count();
        $new_task_count = $new_task_count->count();
        $inprocess_task_count = $inprocess_task_count->count();
        $complete_task_count = $complete_task_count->count(); 
        $total_client = User::where('role_id', 4)->count();
        $total_employee = User::where('role_id', 3)->count(); 
        $recent_tasks = $recent_tasks->orderBy('id', 'desc')->paginate(10);
        return view('backend.dashboard.super_admin_dashboard', compact('all_task_count', 'new_task_count', 
            'inprocess_task_count', 'complete_task_count', 'total_client', 'total_employee', 'recent_tasks'));
        // if(Auth::user()->role_id == 1){ 
        //     return view('backend.dashboard.super_admin_dashboard', compact('all_task_count', 'new_task_count', 
        //     'inprocess_task_count', 'complete_task_count', 'total_client', 'total_employee'));
        // }else if(Auth::user()->role_id == 2){
        //     return view('backend.dashboard.super_admin_dashboard');
        // }else if(Auth::user()->role_id == 3){
        //     return view('backend.dashboard.super_admin_dashboard');
        // }else if(Auth::user()->role_id == 4){
        //     return view('backend.dashboard.super_admin_dashboard');
        // } 
    }
    public function DashboardRedirect(){
        return redirect('/admin/dashboard');
    }
}
