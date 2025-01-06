<?php

namespace App\Http\Controllers\Backend;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;  
use App\Models\Backend\AdditionalRightsComment;
use App\Models\Backend\AdditionalRightsRequest;
use Auth;
use Carbon\Carbon;
use Crypt;
use DB;
use File;
use Illuminate\Http\Request;

class AdditionalRightsRequestController extends Controller{
    public function index(){
        $right_requests = AdditionalRightsRequest::with('getRaisedBy');
        if(Auth::user()->role_id == 4){
            $right_requests = $right_requests->where('raised_by', Auth::user()->id);
        }
        $right_requests =$right_requests->orderBy('id', 'desc')->paginate(20);
        return view('backend.aditional_rights_request.index', compact('right_requests'));
    }
    public function create(){
        if(Auth::user()->role_id == 4){
        return view('backend.aditional_rights_request.create');
        }else{
            return view('errors.403');
        }
    }
    public function store(Request $request){
        $validate = $request->validate([
            "reason" => ['required']
        ]);
        $last_request_number = DB::table('additional_rights_requests')->max('request_number');  
        $new_request_number = $last_request_number ? $last_request_number + 1 : 111001;  
        $new_request = AdditionalRightsRequest::create([
            "request_number" => $new_request_number,
            "raised_by" => Auth::user()->id,
            "reason" => $request->reason,
            "resolution_status" =>1,
            "status" => 1
        ]);
        if($request->hasFile('attachment')){
            $attachment_file = $request->file('attachment');
            $originalName = $attachment_file->getClientOriginalName();  
            $extension = $attachment_file->getClientOriginalExtension(); 
            $attachment_name = time() . '.' . $extension;  
            $attachment_path = public_path('rights_request/attachment');
            $attachment_file->move($attachment_path, $attachment_name);
            AdditionalRightsRequest::where('id', $new_request->id)->update([
                'file' => $attachment_name,
                'original_file_name' => $originalName,
                'file_url' => 'rights_request/attachment'
            ]);  
        }  
        $notificationData = [
            'text' => 'New ticket raised by '.Auth::user()->name,
            'for' => 1,
            'by' => Auth::user()->id,
            'url' => (route('backend.additional_rights_request.view', [Crypt::encrypt($new_request->id)])),
            'icon' => '<i class="ri-ticket-2-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        return redirect()->route('backend.authority_matrix.index')->with('created', 'Your request has been successfully submitted.');
    }
    public function view($req_id){
        $decrypt_req_id = Crypt::decrypt($req_id); 
        $right_req = AdditionalRightsRequest::where('id', $decrypt_req_id)->first();
        $total_request_count = AdditionalRightsRequest::where('raised_by', $right_req->getRaisedBy?->id)->count();
        $pending_request_count = AdditionalRightsRequest::where('resolution_status', 1)->where('raised_by', $right_req->getRaisedBy?->id)->count();
        $accepted_request_count = AdditionalRightsRequest::where('resolution_status', 2)->where('raised_by', $right_req->getRaisedBy?->id)->count();
        $denied_request_count = AdditionalRightsRequest::where('resolution_status', 3)->where('raised_by', $right_req->getRaisedBy?->id)->count();
        $comments = AdditionalRightsComment::with('getUser')->where('request_id', $decrypt_req_id)->get();
        return view('backend.aditional_rights_request.view', compact('right_req', 'total_request_count',
        'pending_request_count', 'accepted_request_count', 'denied_request_count', 'comments'));
    }
    public function updateCurrentStatus(Request $request){
        try{
            $decrypt_request_id = Crypt::decrypt($request->request_id);
            $rights_request = AdditionalRightsRequest::where('id', $decrypt_request_id)->first();
            $text = '';
            AdditionalRightsRequest::where('id', $decrypt_request_id)->update([
                'resolution_status' => $request->current_status
            ]);
            if($request->current_status  == 1){
                $text = "Your Request is pending";
            }elseif($request->current_status  == 2){
                $text = "Your request has been accepted";
                $current_date = Carbon::now();
                AdditionalRightsRequest::where('id', $decrypt_request_id)->update([
                    'resolution_date' => $current_date
                ]);
            }elseif($request->current_status == 3){
                $text = "Your request has been denied"; 
            }
            $notificationData = [
                'text' => $text,
                'for' => $rights_request->raised_by,
                'by' => Auth::user()->id,
                'url' => (route('backend.additional_rights_request.view', [Crypt::encrypt($rights_request->id)])),
                'icon' => '<i class="ri-ticket-2-line font-20"></i>',
                'status' => 1
            ];
            event (new NotificationEvent($notificationData));
            return response()->json([
                "status" => "success",
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ], 200);
        }
    }
    public function commentOnRequest(Request $request){
        $validate = $request->validate([
            "comment" => ['required'],
            "request_id" => ['required']
        ]);
        $decrypt_request_id = Crypt::decrypt($request->request_id);
        AdditionalRightsComment::create([
            "user_id" => Auth::user()->id,
            "request_id" => $decrypt_request_id,
            "comment" => $request->comment,
            "seen_status" => 1,
            "status" => 1
        ]);
        $request = AdditionalRightsRequest::where('id', $decrypt_request_id)->first();
        $for_user = '';
        if(Auth::user()->role_id == 4){
            $for_user = 1;
        }else{
            $for_user = $request->raised_by;
        }
        $notificationData = [ 
            'text' => 'You have a new reply on additional rights request',
            'for' => $for_user,
            'by' => Auth::user()->id,
            'url' => (route('backend.additional_rights_request.view', [Crypt::encrypt($decrypt_request_id)])),
            'icon' => '<i class="ri-reply-all-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        return redirect()->back()->with('posted', 'Your reply successfully posted.');
    }
    public function viewRequestDoc($file){
        $decrypt_file = Crypt::decrypt($file);
        $right_request = AdditionalRightsRequest::where('file', $decrypt_file)->first();
        $file_type = File::extension($decrypt_file);  
        return view('backend.aditional_rights_request.view_request_doc', compact('right_request', 'file_type'));
    }
}
