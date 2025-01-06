<?php
namespace App\Http\Controllers;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class ProfileController extends Controller{
    public function index(){
        return view('backend.profile.index');
    }
    public function update(Request $request){
        $validate = $request->validate = [
            "name" => ["required"]
        ];
        User::where('id', Auth::user()->id)->update([
            "name" => $request->name,
            "phone" => $request->phone
        ]);
        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            $file_ext = $file->getClientOriginalExtension();
            $file_name = time().'.'.$file_ext;
            $path = public_path('assets/backend/images/users');
            $file->move($path, $file_name);
            User::where('id', Auth::user()->id)->update([
                "profile" => 'assets/backend/images/users/'.$file_name
            ]);
        } 
        return redirect()->back()->with('profile_updated', 'Profile has been updated successfully.');
    }
}
