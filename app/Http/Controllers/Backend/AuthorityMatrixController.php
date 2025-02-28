<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalRightsRequest;
use App\Models\Backend\AuthorityMatrix;
use App\Models\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
class AuthorityMatrixController extends Controller{
    public function index(){
        $right_requests = '';
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4){
            $clients = User::with(['getAuthorityMatrix', 'getCompanyDetail']);
            if(Auth::user()->role_id == 4){
                $clients = $clients->where('id', Auth::user()->id);
            }
            if(Auth::user()->role_id == 4){
                $right_requests = AdditionalRightsRequest::where('raised_by', Auth::user()->id)->get();
            } 
            $clients = $clients->where('role_id', 4)->orderBy('id', 'desc')->get(); 
            return view('backend.authority_matrix.index', compact('clients', 'right_requests'));
        }else{
            return view('errors.403');
        }
    }
    public function createRights($user_id){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            try{
                $decrypt_user_id = Crypt::decrypt($user_id);
                $user = User::where('id', $decrypt_user_id)->first();
                $rights = AuthorityMatrix::where('user_id', $decrypt_user_id)->pluck('permission')->toArray();
                return view('backend.authority_matrix.rights', compact('user', 'rights'));
            }catch(\Exception $e){
                abort('404');   
            } 
        }else{
            return view('errors.403');
        }
    }
    public function syncRights(Request $request){
        $user_id = $request->user_id;
        if($request->has('rights')){
            $rights = $request->rights;
            AuthorityMatrix::where('user_id', $user_id)->delete(); 
            foreach($rights as $right){
                AuthorityMatrix::create([
                   "user_id"  => $user_id,
                   "permission" => $right, 
                   "permission_given_by" => Auth::user()->id, 
                ]); 
            }
        }else{
            AuthorityMatrix::where('user_id', $user_id)->delete();
        }
        return redirect()->back()->with('right_updated', "Rights has been updated.");
    } 
}