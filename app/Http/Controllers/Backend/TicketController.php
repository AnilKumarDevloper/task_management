<?php
namespace App\Http\Controllers\Backend;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalRightsRequest;
use App\Models\Backend\Ticket;
use App\Models\Backend\TicketComment;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Crypt;
use DB;
use File;
use Illuminate\Http\Request;
class TicketController extends Controller{
    public function index(){
        $right_requests = '';
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4){
            $tickets = Ticket::with('getRaisedBy:id,name');
            if(Auth::user()->role_id == 3){
                $tickets = $tickets->where('raised_by', Auth::user()->client_id);
            } 
            if(Auth::user()->role_id == 4){
                $right_requests = AdditionalRightsRequest::where('raised_by', Auth::user()->id)->get();
                $tickets = $tickets->where('raised_by', Auth::user()->id);
            }
            $tickets = $tickets->orderBy('id', 'desc')->paginate(20); 
            return view('backend.ticket.index', compact('tickets', 'right_requests'));
        }else{
            return view('errors.403');
        }
    }
    public function create(){ 
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4){
            return view('backend.ticket.create'); 
        }else{
            return view('errors.403');
        }
    }
    public function store(Request $request){
        $request->validate([
            'question' => ['required']
        ]); 
        try{ 
            $last_ticket_number = DB::table('tickets')->max('ticket_number');  
            $new_ticket_number = $last_ticket_number ? $last_ticket_number + 1 : 111001;  
            $new_ticket = Ticket::create([
                "ticket_number" => $new_ticket_number,
                "raised_by" => Auth::user()->id,
                "question" => $request->question,
                "resolution_status" => 1
            ]);
            if($request->hasFile('attachment')){
                $attachment_file = $request->file('attachment');
                $originalName = $attachment_file->getClientOriginalName(); 
                $extension = $attachment_file->getClientOriginalExtension();
                $attachment_name = time() . '.' . $extension;  
                $attachment_path = public_path('ticket/attachment');
                $attachment_file->move($attachment_path, $attachment_name);
                Ticket::where('id', $new_ticket->id)->update([
                    'file' => $attachment_name,
                    'original_file_name' => $originalName,
                    'file_url' => 'ticket/attachment'
                ]);  
            }
            $notificationData = [
                'text' => 'A new ticket has been raised by '.Auth::user()->name.'.',
                'for' => 1,
                'by' => Auth::user()->id,
                'url' => (route('backend.ticket.view', [Crypt::encrypt($new_ticket->id)])),
                'icon' => '<i class="ri-ticket-2-line font-20"></i>',
                'status' => 1
            ];
            event (new NotificationEvent($notificationData));
            return redirect()->route('backend.ticket.index')->with('created', 'Your ticket has been successfully submitted.');
        }catch(\Exception $e){ 
            abort('404');
        }
    }
    public function view($id){
        $decrypt_id = Crypt::decrypt($id);  
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4){
            $ticket = Ticket::with('getRaisedBy')->where('id', $decrypt_id)->first();
            $total_ticket_count = Ticket::where('raised_by', $ticket->getRaisedBy?->id)->count();
            $pending_ticket_count = Ticket::where('resolution_status', 1)->where('raised_by', $ticket->getRaisedBy?->id)->count();
            $inprogress_ticket_count = Ticket::where('resolution_status', 2)->where('raised_by', $ticket->getRaisedBy?->id)->count();
            $close_ticket_count = Ticket::where('resolution_status', 3)->where('raised_by', $ticket->getRaisedBy?->id)->count();
            $comments = TicketComment::with('getUser')->where('ticket_id', $decrypt_id)->get();
            return view('backend.ticket.view', compact('ticket', 'total_ticket_count', 
            'pending_ticket_count', 'inprogress_ticket_count', 'close_ticket_count', 'comments'));
        }else{
            return view('errors.403');
        } 
    }
    public function commentOnTicket(Request $request){
        $validate = $request->validate([
            "comment" => ['required'],
            "ticket_id" => ['required']
        ]);
        $decrypt_ticket_id = Crypt::decrypt($request->ticket_id);
        TicketComment::create([
            "user_id" => Auth::user()->id,
            "ticket_id" => $decrypt_ticket_id,
            "comment" => $request->comment
        ]);
        $ticket = Ticket::where('id', $decrypt_ticket_id)->first();
        $for_user = '';
        if(Auth::user()->role_id == 4){
            $for_user = 1;
        }else{
            $for_user = $ticket->raised_by;
        }

        $notificationData = [ 
            'text' => 'You have received a new reply on the ticket',
            'for' => $for_user,
            'by' => Auth::user()->id,
            'url' => (route('backend.ticket.view', [Crypt::encrypt($decrypt_ticket_id)])),
            'icon' => '<i class="ri-reply-all-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        
        return redirect()->back()->with('posted', 'Your reply successfully posted.');
    }
    public function updateCurrentStatus(Request $request){
        try{
            $decrypt_ticket_id = Crypt::decrypt($request->ticket_id);
            $ticket = Ticket::where('id', $decrypt_ticket_id)->first();
            $text = '';
            Ticket::where('id', $decrypt_ticket_id)->update([
                'resolution_status' => $request->current_status
            ]); 
            if($request->current_status  == 1){
                $text = "Your ticket is pending";
            }elseif($request->current_status  == 2){
                $text = "Your ticket is in progress";
            }elseif($request->current_status == 3){
                $text = "Your has been closed"; 
                $current_date = Carbon::now();
                Ticket::where('id', $decrypt_ticket_id)->update([
                    'resolution_date' => $current_date
                ]);
            } 
            $notificationData = [ 
                'text' => $text,
                'for' => $ticket->raised_by,
                'by' => Auth::user()->id,
                'url' => (route('backend.ticket.view', [Crypt::encrypt($ticket->id)])),
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
    public function viewTicketDoc($file){
        $decrypt_file = Crypt::decrypt($file);
        $ticket = Ticket::where('file', $decrypt_file)->first();
        $file_type = File::extension($decrypt_file);  
        return view('backend.ticket.view_ticket_doc', compact('ticket', 'file_type'));
    }

    public function sendTicketReminder(Request $request){
        try{
            $sender_name = '';
            $ticket_id = $request->ticket_id; 
            Ticket::where('id', $ticket_id)->update([
                "reminder_status" => 1,
            ]);
            Ticket::where('id', $ticket_id)->increment('reminder_count', 1);
            $ticket = Ticket::where('id', $ticket_id)->first();
            $employee = User::where('client_id', $ticket->raised_by)->first();
            
            if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2){
                $notificationData = [
                    'text' => Auth::user()->name.' has sent you a reminder for the ticket.',
                    'for' => 1, 
                    'by' => Auth::user()->id,
                    'url' => (route('backend.ticket.view', [Crypt::encrypt($ticket->id)])),
                    'icon' => '<i class="ri-notification-2-line font-20"></i>',
                    'status' => 1
                ];
                event (new NotificationEvent($notificationData));
            } 
            if($employee != ''){
                $notificationData = [
                    'text' => Auth::user()->name.' has sent you a reminder for the ticket.',
                    'for' => $employee->id,
                    'by' => Auth::user()->id,
                    'url' => (route('backend.ticket.view', [Crypt::encrypt($ticket->id)])),
                    'icon' => '<i class="ri-notification-2-line font-20"></i>',
                    'status' => 1
                ];
                event (new NotificationEvent($notificationData));
            }
            return response()->json([
                "status" => "success",
                "reminder_count" => $ticket->reminder_count,
            ]);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }
    
}
