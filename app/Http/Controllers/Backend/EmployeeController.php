<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\EmployeeAndClient;
use App\Models\Backend\Task;
use App\Models\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
    
class EmployeeController extends Controller{
    public function index(Request $request){ 
        try{
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $search = $request->search; 
            $users = User::with(['getEmployeeTask'])->where('role_id', 3);
            // ->where('status', 1);
            if (!empty($search)) {
                $users = $users->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%')
                          ->orWhere('email', 'LIKE', '%' . $search . '%')
                          ->orWhere('phone', 'LIKE', '%' . $search . '%');
                });
            }
            $users = $users->withTrashed()->orderBy('id', 'desc')
           ->paginate(100); 
            $users->appends([ 
            'search' => isset($_GET['search']) ? $_GET['search'] : '',
            ]);  
            return view('backend.employee.employee_list', compact('users'));
        }else{
            return response()->view('errors.403', [], 403);
        }
        }catch(\Exception $e){
            abort('404');
        }
    }

 
    public function create(){
        try{
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $clients = User::with('getCompanyDetail')->where('role_id', 4)->where('status', 1)->get();
            return view('backend.employee.create', compact('clients'));
        }else{ 
            return response()->view('errors.403', [], 403);
        }
    }catch(\Exception $e){
        abort('404');
    }
    }
    public function store(Request $request){ 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'digits:10', 'unique:'.User::class], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), 
            'role_id' => 3,
            'client_id' => $request->client,
            'created_by' => Auth::user()->id,
            'status' => 1
        ]);
        if($request->clients != ''){
            $clientIdsAsStrings = $request->input('clients');  
            $clientIdsAsIntegers = array_map('intval', $clientIdsAsStrings); 
            User::where('id', $user->id)->update([
                "clients" => $clientIdsAsIntegers
            ]);
            foreach($clientIdsAsIntegers as $client){
                EmployeeAndClient::create([
                    "user_id" => $user->id,
                    "client_id" => $client
                ]);
            }
        } 
        return redirect()->route('backend.employee.index')->with('created', 'Employee has been Added.');
    }
    public function edit($id){
        try{
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            try{
                $decrypt_id = Crypt::decrypt($id); 
                $user = User::with('getClient')->where('id', $decrypt_id)->withTrashed()->first();
                /*
                |---------------------------------------------------------------------------------------------------------
                | this will be usefull when multiple client assigned to a employee
                |---------------------------------------------------------------------------------------------------------
                */
                $assigned_clients = EmployeeAndClient::where('user_id', $decrypt_id)->pluck('client_id')->toArray();
                $clients = User::with('getCompanyDetail')->where('role_id', 4)->where('status', 1)->get();
                
                return view('backend.employee.edit', compact('user', 'clients', 'assigned_clients')); 
            }catch(\Exception $e){
                // return $e->getMessage();
                abort('404');
            }
        }else{
            return response()->view('errors.403', [], 403);
        }
    }catch(\Exception $e){
        abort('404');
    }
    }
    public function update(Request $request, $id){  
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'digits:10'],
        ]);
        $decrypt_id = Crypt::decrypt($id);   

        User::where('id', $decrypt_id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            // "client_id" => $request->client
        ]);
        /*
        |---------------------------------------------------------------------------------------------------------
        | this is usefull when we are assigning multiple client to a employee
        |---------------------------------------------------------------------------------------------------------
        */
        if($request->clients != ''){
              $clientIdsAsStrings = $request->input('clients'); 
              $clientIdsAsIntegers = array_map('intval', $clientIdsAsStrings); 
              User::where('id', $decrypt_id)->update([
                "clients" => $clientIdsAsIntegers
            ]);
              EmployeeAndClient::where('user_id', $decrypt_id)->delete();
              foreach($clientIdsAsIntegers as $client){
                  EmployeeAndClient::create([
                      "user_id" => $decrypt_id,
                      "client_id" => $client
                  ]);
              }
          }else{
            User::where('id', $decrypt_id)->update([
                "clients" => NULL
            ]);
            EmployeeAndClient::where('user_id', $decrypt_id)->delete();
          }
        return redirect()->route('backend.employee.index')->with('updated', 'Employee has been updated.');
    }
    public function destroy($id){
        try{
            $decrypt_id = Crypt::decrypt($id);
            User::where('id', $decrypt_id)->delete();
            return response()->json([
                "status" => "success"
            ], 200);
        }catch(\Exception $e){
            abort('404');
        }
    }

    public function changeStatus(Request $request){
        try{
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
                $status = $request->status_value;
                $user_id = $request->user_id;
                if($status == 1){
                    User::where('id', $user_id)->restore();
                    User::where('id', $user_id)->update(['status' => 1]);
                }else{
                    User::where('id', $user_id)->update(['status' => 0]);
                    User::where('id', $user_id)->delete();
                } 
                return response()->json([
                    "status" => "success",
                ], 200);
            }else{
                return response()->json([
                    "status" => "permission_denied"
                ], 403);
            } 
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ], 400);
        } 
    } 
    public function viewEmployeeTasks($id){ 
        try{
            if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2){
                return response()->view('errors.403', [], 403);
            }
        $decrypt_id = Crypt::decrypt($id);
        $user = User::with(['getClient'])->where('id', $decrypt_id)->first();
        // return $user;
        $total_count = Task::where('assigned_to', $decrypt_id)->count();
        $pending_count = Task::where('assigned_to', $decrypt_id)->where('current_status', 'pending')->count();
        $inprocess_count = Task::where('assigned_to', $decrypt_id)->where('current_status', 'inprocess')->count();
        $completed_count = Task::where('assigned_to', $decrypt_id)->where('current_status', 'completed')->count();
        return view('backend.employee.view_employee_tasks', compact('id', 'pending_count', 'inprocess_count', 'completed_count', 'total_count', 'user'));
    }catch(\Exception $e){
        abort('404');
    }
    }
}
