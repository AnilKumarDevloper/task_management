<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AuthorityMatrix;
use App\Models\Backend\CompanyDetail;
use App\Models\Backend\EmployeeAndClient;
use App\Models\Backend\MainFolder;
use App\Models\Backend\MonthFolder;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Str;
class ClientController extends Controller{
    public function index(){
        if(Auth::user()->role_id == 4){
            return response()->view('errors.403', [], 405);
        }

        $users = User::with('GetCompanyDetail')->where('role_id',4);
        if(Auth::user()->role_id == 3){
            $clients = EmployeeAndClient::where('user_id', Auth::user()->id)->pluck('client_id')->toArray();
            $users = $users->whereIn('id', $clients);
            // $users = $users->where('id', Auth::user()->client_id);
        } 
        $users = $users->withTrashed()->orderBy('id', 'desc')->get();
        return view('backend.client.index', compact('users'));
    }
    public function create(){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            return view('backend.client.create');
        }else{
            return response()->view('errors.403', [], 403);
        }
    }
    public function store(Request $request){
        $validate = $request->validate([
            'company_name' => ['required'],
            'company_phone' => ['required', 'digits:10'],
            'company_address' => ['required'],
            'user_name' => ['required'],
            'phone' => ['required', 'digits:10', 'unique:'.User::class], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $company_name = $request->company_name;
        $company_phone = $request->company_phone;
        $company_address = $request->company_address;
        $company_logo = $request->company_logo;
        $user_name = $request->user_name;
        $user_phone = $request->phone;
        $user_email = $request->email; 
        $user = User::create([
            'name' => $user_name,
            'email' => $user_email,
            'phone' => $user_phone,
            'password' => Hash::make($request->password),
            'role_id' => 4,
            'created_by' => Auth::user()->id,
            'status' => 1
        ]);
       $new_company =  CompanyDetail::create([
            'user_id' => $user->id,
            'name' => $company_name,
            'phone' => $company_phone,
            'address' => $company_address,
            'status' => 1 
        ]);
        AuthorityMatrix::create([
            'user_id' => $user->id,
            'permission' => 'view',
            'permission_given_by' => Auth::user()->id,
        ]);
        if($request->hasFile('company_logo')){
            $logo = $request->file('company_logo');
            $originalName = $logo->getClientOriginalName(); 
            $extension = $logo->getClientOriginalExtension();
            $logo_name = time() . '.' . $extension;  
            $logo_path = public_path('company_logo');
            $logo->move($logo_path, $logo_name);
            CompanyDetail::where('id', $new_company->id)->update([
                'logo' => $logo_name,
                'logo_original_name' => $originalName,
                'logo_url' => 'company_logo'
            ]); 
        }
        /*
        |---------------------------------------------------------------------------------------------------------
        | this will be usefull when we create folder of the client and company
        |---------------------------------------------------------------------------------------------------------
        |   $sanitized_folder_name = Str::slug($company_name, '_');
        |   $directoryPath = public_path('client_data/'.$sanitized_folder_name); 
        |   if (!file_exists($directoryPath)){
        |       File::makeDirectory($directoryPath, 0755, true); 
        |   }
        |   $main_folder = MainFolder::create([
        |       "name" => $sanitized_folder_name,
        |       "label" => $company_name,
        |       "client_id" => $user->id,
        |       "status" => 1,
        |   ]);
        |   $currentYear = Carbon::now()->format('Y');
        |   $year_folder_name = range(2023, $currentYear);
        |   foreach($year_folder_name as $year){
        |       $year_folder = YearFolder::create([
        |           "name" => $year,
        |           "label" => $year,
        |           "main_folder_id" => $main_folder->id, 
        |       ]); 
        |       $directoryPath = public_path('client_data/'.$sanitized_folder_name.'/'.$year); 
        |       if (!file_exists($directoryPath)) {
        |           File::makeDirectory($directoryPath, 0755, true); 
        |       } 
        |       $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        |       foreach($months as $month){
        |           MonthFolder::create([
        |               "name" => $month,
        |               "label" => $month,
        |               "main_folder_id" => $main_folder->id,
        |               "year_folder_id" => $year_folder->id
        |           ]);
        |           $directoryPath = public_path('client_data/'.$sanitized_folder_name.'/'.$year.'/'.$month); 
        |           if(!file_exists($directoryPath)) {
        |               File::makeDirectory($directoryPath, 0755, true); 
        |           }
        |       }
        |   }
        |---------------------------------------------------------------------------------------------------------
        */
        return redirect()->route('backend.client.index')->with('created', 'Client has been added.');
    }
    public function edit($id){
        try{
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $decrypt_id = Crypt::decrypt($id);
            $user = User::with('GetCompanyDetail')->where('id', $decrypt_id)
            ->withTrashed()->first();
            return view('backend.client.edit', compact('user'));
            }else{
                return response()->view('errors.403', [], 403);
            }
        }catch(\Exception $e){  
            abort('404');
        }
    }
    public function update(Request $request,  $id){
        $validate = $request->validate([
            'company_name' => ['required'],
            'company_phone' => ['required', 'digits:10'],
            'company_address' => ['required'],
            'user_name' => ['required'],
            'phone' => ['required', 'digits:10'], 
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        ]);
        $company_name = $request->company_name;
        $company_phone = $request->company_phone;
        $company_address = $request->company_address;
        $user_name = $request->user_name;
        $user_phone = $request->phone;
        $user_email = $request->email; 
        $decrypt_id = Crypt::decrypt($id);
        User::where('id', $decrypt_id)->update([
            'name' => $user_name,
            'email' => $user_email,
            'phone' => $user_phone, 
        ]);
        if($request->password != ""){
            User::where('id', $decrypt_id)->update([
                'password' => Hash::make($request->password),
            ]);
        }
        if($request->hasFile('company_logo')){
            $logo = $request->file('company_logo');
            $originalName = $logo->getClientOriginalName(); 
            $extension = $logo->getClientOriginalExtension();
            $logo_name = time() . '.' . $extension;  
            $logo_path = public_path('company_logo');
            $logo->move($logo_path, $logo_name);
            CompanyDetail::where('user_id', $decrypt_id)->update([
                'logo' => $logo_name,
                'logo_original_name' => $originalName,
                'logo_url' => 'company_logo'
            ]); 
        }
        CompanyDetail::where('user_id', $decrypt_id)->update([
            'name' => $company_name,
            'phone' => $company_phone,
            'address' => $company_address,
            'status' => 1
        ]);
        return redirect()->route('backend.client.index')->with('updated', 'Client has been updated.');
    }
    public function view($id){
        $decrypt_id = Crypt::decrypt($id);
        $user = User::with('GetCompanyDetail')->where('id', $decrypt_id)->withTrashed()->first();
        return view('backend.client.view', compact('user'));
    }
    public function destroy($id){
        try{
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
                $decrypt_id = Crypt::decrypt($id);
                User::where('id', $decrypt_id)->delete(); 
                return response()->json([
                    "status" => "success",  
                ]);
            }else{
                return response()->view('errors.403', [], 403);
            }
        }catch(\Exception $e){
            return response()->json([
                "status" => 'failed',
                "error" => $e->getMessage()
            ]);
        }
    }

    public function changeStatus(Request $request){
        try{
            $user_id = $request->user_id;
            $status_value = $request->status_value;
            if($status_value == 1){
                User::where('id', $user_id)->restore();
                User::where('id', $user_id)->update(['status' => 1]);
            }else{
                User::where('id', $user_id)->update(['status' => 0]);
                User::where('id', $user_id)->delete();
            }
            return response()->json([
                "status" => "success",
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ], 400);
        }
    }


}
