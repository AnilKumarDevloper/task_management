<?php 
namespace App\Http\Controllers\Backend;

use App\Events\NotificationEvent;
use App\Exports\TaskExport;
use App\Http\Controllers\Controller;
use App\Models\Backend\AuthorityMatrix;
use App\Models\Backend\Document;
use App\Models\Backend\DocumentComment;
use App\Models\Backend\EmployeeAndClient;
use App\Models\Backend\FinancialYearList;
use App\Models\Backend\MainFolder;
use App\Models\Backend\Task;
use App\Models\Backend\TaskDocument;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
class TaskController extends Controller{
    public function getTaskList(Request $request){
        try{
            $tasks = Task::with(['getEmployee:id,name', 'getClient:id,name', 'getAssignedBy:id,name', 'getAmendedBy:id,name'])->where('status', 1);
            if (Auth::user()->role_id == 3){
                $tasks->where('assigned_to', Auth::user()->id);
            }elseif (Auth::user()->role_id == 4){
                $tasks->where('client_id', Auth::user()->id);
            } 
            $tasks = $tasks->orderBy('year', 'desc')->get()->groupBy('year');
            $taskList = [];
            foreach ($tasks as $year => $months){
                $yearData = [
                    'id' => uniqid(),
                    'year' => $year,
                    'month' => []
                ];
                foreach($months->groupBy('month') as $month => $monthTasks) {
                    $monthData = [
                        'monthName' => $month,
                        'due_Date' => $monthTasks->max('compliance_date'),
                        'task' => $monthTasks->map(function ($task) {
                            $task->enc_id = Crypt::encrypt($task->id);
                            return $task;
                        }),
                    ];
                    $yearData['month'][] = $monthData;
                }
                $taskList[] = $yearData;
            }
            $rights = AuthorityMatrix::where('user_id', Auth::user()->id)->pluck('permission')->toArray();
         
            return response()->json([
                'status' => 'success',
                'task_list' => $taskList,
                'role_id' => Auth::user()->role_id, 
                'rights' => $rights
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function index(Request $request){
        $tasks = Task::select('*')->with(['getEmployee:id,name', 'getClient:id,name', 'getAssignedBy:id,name', 'getAmendedBy:id,name']);
        if(Auth::user()->role_id == 4){
            $tasks = $tasks->where('client_id', Auth::user()->id);
        }
        elseif(Auth::user()->role_id == 3){
            if(Auth::user()->clients != ''){ 
                $tasks = $tasks->whereIn('client_id', Auth::user()->clients);
            }else{ 
                $tasks = $tasks->where('client_id', Auth::user()->client_id);
            }
        }
        $tasks = $tasks->orderBy('year', 'desc')
        ->get()
        ->groupBy('client_id')
        ->map(function ($clientGroup){
            return $clientGroup->groupBy('year')->map(function ($yearGroup){
                return $yearGroup->groupBy('month');
            });
        }); 
        return view('backend.task.index', compact('tasks'));
    }
    // to assign task from folder (not in use now) start
        public function store(Request $request){ 
            $validate = $request->validate([
                "start_date" => ['required'],
                "end_date" => ['required'],
                "employee" => ["required"]
            ]);

            $doc_id = $request->doc_id;
            $main_folder_id = $request->main_f_id;
            $year_folder_id = $request->year_f_id;
            $month_folder_id = $request->month_f_id;
            $employee_id = $request->employee;
            $start_date = $request->start_date;
            $end_date = $request->end_date;
    
            $document = Document::where('id', $doc_id)->first();
            Task::create([
                "doc_file" => $document->doc_file,
                "doc_path" => $document->doc_path,
                "document_id" => $doc_id,
                "assigned_by" => Auth::user()->id,
                "assigned_to" => $employee_id,
                "start_date" => $start_date,
                "due_date" => $end_date,
                "end_date" => $end_date,
                "main_folder_id" => $main_folder_id,
                "year_folder_id" => $year_folder_id,
                "month_folder_id" => $month_folder_id,
                "current_status" => 'pending'
            ]);
            return redirect()->back()->with('task_created', "New task has been assigned successfully.");
        }
    // to assign task from folder (not in use now) end
     public function storeFromTaskList(Request $request){
        $validate = $request->validate([
            "employee" => ["required"],
            "client" => ["required"],
            "year" => ["required"],
            "month" => ["required"]
        ]);
        $task = Task::create([
            'title'=> $request->title,
            "assigned_to" => $request->employee,
            "client_id" => $request->client,
            "year" => $request->year,
            "month" => $request->month,
            "start_date" => $request->start_date,
            "due_date" => $request->due_date, 
            "compliance_date" => $request->compliance_date, 
            "description" => $request->description, 
            "assigned_by" => Auth::user()->id,
            "current_status" => 'pending'
        ]);
        if($request->compliance_date != ''){
            Task::where('id', $task->id)->update([
                'current_status' => 'completed'
            ]);
        }
        if($request->hasFile('document')){
            $documentPath = public_path('client_data/tasks');
            $documentFiles = $request->file('document');
            foreach($documentFiles as $doc){
                $extension = $doc->getClientOriginalExtension();
                $originalFileName = $doc->getClientOriginalName();
                $documentName = time() . '.' . $extension;  
                $doc->move($documentPath, $documentName);  
                TaskDocument::create([
                    'task_id' => $task->id,
                    'file' => $documentName,
                    'file_original_name' => $originalFileName,
                    'file_path' => 'client_data/tasks'
                ]);  
            }   
        }  
        $notificationData = [ 
            'text' => 'You have received a new task.',
            'for' => $request->employee,
            'by' => Auth::user()->id,
            'url' => (route('backend.task.view', [Crypt::encrypt($task->id)])),
            'icon' => '<i class="ri-task-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        return redirect()->route('backend.task.index')->with('assigned', 'Task has been assigned successfully.');
    }
    public function view($task_id){
        if(Auth::user()->role_id == 4){
            $permission = AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'view')->exists();
            if(!$permission){
                return view('errors.403');
            } 
        }
        $decrypt_task_id = Crypt::decrypt($task_id); 
        $task = Task::with(['getEmployee', 'getDocument', 'getTaskDocument'])->where('id', $decrypt_task_id)->first();
        $comments = DocumentComment::with(['getUser', 'getReplys'])->where('task_id', $decrypt_task_id)->get();
        return view('backend.task.view', compact('task', 'comments'));
    } 
    public function edit($task_id){
        if(Auth::user()->role_id == 4){
            $permission = AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'edit')->exists();
            if(!$permission){
                return view('errors.403');
            } 
        }
        $decrypt_id = Crypt::decrypt($task_id);
        $task = Task::with('getClient', 'getEmployee', 'getTaskDocument')->where('id', $decrypt_id)->first();
        $employees = User::where('role_id', 3)->get();
        $financial_years = FinancialYearList::where('status', 1)->get();
        $clients = User::where('role_id', 4);
        if(Auth::user()->role_id == 3){
            $clients = $clients->where('id', Auth::user()->client_id);
        }
        $clients = $clients->where('status', 1)->get();
        return view('backend.task.edit', compact('task','employees', 'financial_years', 'clients'));
    }
    public function update(Request $request, $task_id){ 
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3){
            $validate = $request->validate([
                "employee" => ["required"],
                "client" => ["required"],
                "year" => ["required"],
                "month" => ["required"], 
            ]); 
            $task = Task::where('id', $task_id)->update([
                'title'=> $request->title,
                "assigned_to" => $request->employee,
                'amended_by' => Auth::user()->id,
                "client_id" => $request->client,
                "year" => $request->year,
                "month" => $request->month,
                "start_date" => $request->start_date,
                "due_date" => $request->due_date,
                "compliance_date" => $request->compliance_date,
                "description" => $request->description,  
                "current_status" => $request->current_status
            ]); 
            if($request->compliance_date != ''){
                $task = Task::where('id', $task_id)->update([  
                    "current_status" => 'completed'
                ]); 
            }
            $task_documents = TaskDocument::where('task_id', $task_id)->pluck('id')->toArray();
            foreach($task_documents as $doc){
               if(!in_array($doc, $request->documents)){
                   TaskDocument::where('id', $doc)->delete();
               }
            }
            if(Auth::user()->role_id != 4){
               $task = Task::where('id', $task_id)->update([
                   'amended_by' => Auth::user()->id,
               ]); 
            }
            if($request->hasFile('new_document')){
               $documentPath = public_path('client_data/tasks');
                  $documentFiles = $request->file('new_document');
                  foreach($documentFiles as $doc){
                    $extension = $doc->getClientOriginalExtension();
                    $originalFileName = $doc->getClientOriginalName();
                    $documentName = time() . '.' . $extension;  
                    $doc->move($documentPath, $documentName);  
                    TaskDocument::create([
                        'task_id' => $task_id,
                        'file' => $documentName,
                        'file_original_name' => $originalFileName,
                        'file_path' => 'client_data/tasks'
                    ]);  
                }   
            }      
        }else{
            Task::where('id', $task_id)->update([
                "current_status" => $request->current_status, 
            ]);
        }
        return redirect()->back()->with('task_updated', "Task has been successfully updated.");
    }
    public function commentOnTask(Request $request){
        $validate = $request->validate([
            "comment" => ["required"]
        ]);
        $task_id = $request->task_id;
        $doc_id = $request->document_id;
        $comment = $request->comment;   
        $task = Task::where('id', $task_id)->first();
        DocumentComment::create([
            "task_id" => $task_id,
            "document_id" => $doc_id,
            "user_id" => Auth::user()->id,
            "comment" => $comment,
            "publish_status" => 1,
            "status" => 1
        ]);
        $for_user = '';
        if(Auth::user()->id == $task->assigned_by){
            $for_user = $task->assigned_to;
        }else{
            $for_user = $task->assigned_by;
        }
        $notificationData = [ 
            'text' => 'You have received a new comment on the task.',
            'for' => $for_user,
            'by' => Auth::user()->id,
            'url' => (route('backend.task.view', [Crypt::encrypt($task_id)])),
            'icon' => '<i class="ri-chat-2-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        return redirect()->back()->with('commented', "Comment Successfull.");
    }
    public function replyOnComment(Request $request){
        $validate = $request->validate([
            "reply" => ["required"]
        ]); 
        $reply = $request->reply;
        $parent_id = $request->parent_id;
        $task_id = $request->task_id;
        $document_id = $request->document_id; 
        $task = Task::where('id', $task_id)->first();
        DocumentComment::create([
            "task_id" => $task_id,
            "document_id" => $document_id,
            "user_id" => Auth::user()->id,
            "parent_id" => $parent_id,
            "comment" => $reply,
            "publish_status" => 1,
            "status" => 1
        ]);
        $for_user = '';
        if(Auth::user()->id == $task->assigned_by){
            $for_user = $task->assigned_to;
        }else{
            $for_user = $task->assigned_by;
        } 
        $notificationData = [ 
            'text' => 'You have received a new reply on your comment.',
            'for' => $for_user,
            'by' => Auth::user()->id,
            'url' => (route('backend.task.view', [Crypt::encrypt($task_id)])),
            'icon' => '<i class="ri-chat-2-line font-20"></i>',
            'status' => 1
        ];
        event (new NotificationEvent($notificationData));
        return redirect()->back()->with('replied', 'Reply successfully sent.');
    }
    public function destroy(Request $request){
        try{
            $task_id = $request->task_id;
            Task::find($task_id)->delete();
            return response()->json([
                "status" => "success",
            ]);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }
    public function assignTask(){
        $employees = User::where('role_id', 3);
        if(Auth::user()->role_id == 3){
            $employees = $employees->where('id', Auth::user()->id);
        }
        $employees = $employees->get();
        $clients = User::with(['getEmployeeAndClient', 'getCompanyDetail'])->where('role_id', 4)->get();
        if(Auth::user()->role_id == 3){
            $clients = $clients->where('id', Auth::user()->client_id);
        }  
        $financial_years = FinancialYearList::where('status', 1)->get();
        return view('backend.task.assign_task', compact('employees',
         'financial_years', 'clients'));
    }
    public function viewTaskDoc($doc_id){
        $decrypt_doc_id = Crypt::decrypt($doc_id);
        $document = TaskDocument::where('id', $decrypt_doc_id)->first();
        $file_type = pathinfo($document->file, PATHINFO_EXTENSION);
        return view('backend.task.view_doc', compact('document', 'file_type'));
    }
    public function downloadTaskDoc($doc_id){
        $decrypt_doc_id = Crypt::decrypt($doc_id);
        $document = TaskDocument::where('id', $decrypt_doc_id)->first();
        return response()->download($document->file_path.'/'.$document->file, $document->file_original_name);
    }

  
 

    public function sendTaskReminder(Request $request){
        try{
            $task_id = $request->task_id; 
            Task::where('id', $task_id)->update([
                "reminder_status" => 1,
            ]);
            Task::where('id', $task_id)->increment('reminder_count', 1);
            $task = Task::where('id', $task_id)->first();
            if(Auth::user()->role_id != 1 && Auth::user()->role_id != 2){
            $notificationData = [
                'text' => Auth::user()->name. ' has sent you a reminder for the ticket.',
                'for' => 1, 
                'by' => Auth::user()->id,
                'url' => (route('backend.task.view', [Crypt::encrypt($task->id)])),
                'icon' => '<i class="ri-notification-2-line font-20"></i>',
                'status' => 1
            ];
            event (new NotificationEvent($notificationData));
            }
            $notificationData = [
                'text' => Auth::user()->name. ' has sent you a reminder for the ticket.',
                'for' => $task->assigned_to,
                'by' => Auth::user()->id,
                'url' => (route('backend.task.view', [Crypt::encrypt($task->id)])),
                'icon' => '<i class="ri-notification-2-line font-20"></i>',
                'status' => 1
            ];
            event (new NotificationEvent($notificationData));
            return response()->json([
                "status" => "success",
                "reminder_count" => $task->reminder_count,
            ]);
        }catch(\Exception $e){  
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function taskExportCSV($client_id, $year, $month){
        return Excel::download(new TaskExport($client_id, $year, $month), 'task-list.csv');
    }

    public function taskImportCSV(Request $request, $client_id){
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);
        try{
            $file = $request->file('csv_file');
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $columns = [
                'id', 'title', 'doc_file', 'doc_path', 'description', 'document_id', 'assigned_by', 'assigned_to', 'client_id', 'year',
                'month', 'start_date', 'start_time', 'end_date', 'end_time', 'compliance_date', 'due_date',
                'main_folder_id', 'year_folder_id', 'month_folder_id', 'current_status', 'amended_by', 'reminder_status',
                'reminder_count', 'running_status', 'status', 'created_at', 'updated_at'
            ];
            foreach($data as $index => $row){
            
            $row = array_pad($row, count($columns), NULL);
                if(count($row) !== count($columns)){
                    return back()->with([
                        'file_not_compatible' => "Row " . ($index + 1) . " has an invalid number of columns. Expected " . count($columns) . " columns."
                    ]);
                } 
                $rowData = array_combine($columns, $row);
                    $integerFields = ['document_id', 'assigned_by', 'assigned_to', 'client_id', 'main_folder_id', 'year_folder_id', 'month_folder_id', 'reminder_count'];
                    foreach ($integerFields as $field) {
                        if (isset($rowData[$field]) && $rowData[$field] === '') {
                            $rowData[$field] = null;
                        }
                    }
                    $reminder_status = in_array($rowData['reminder_status'] ?? null, [0, 1]) 
                    ? (int)$rowData['reminder_status'] 
                    : 0;
                    $compliance_date = !empty($rowData['compliance_date']) ? $rowData['compliance_date'] : null;
                    $amended_by = !empty($rowData['amended_by']) ? $rowData['amended_by'] : null;
                
                   $new_task = Task::create([
                    'title' => $rowData['title'] ?? NULL,
                    'doc_file' => $rowData['doc_file'] ?? NULL,
                    'doc_path' => $rowData['doc_path'] ?? NULL,
                    'description' => $rowData['description'] ?? NULL,
                    'document_id' => $rowData['document_id'] ?? NULL,
                    'assigned_by' => $rowData['assigned_by'] ?? NULL,
                    'assigned_to' => $rowData['assigned_to'] ?? NULL,
                    'client_id' => $client_id,
                    'year' => $rowData['year'] ?? NULL,
                    'month' => $rowData['month'] ?? NULL,
                    'start_date' => $rowData['start_date'] ?? NULL,
                    'start_time' => isset($rowData['start_time']) && !empty($rowData['start_time']) ? date('H:i:s', strtotime($rowData['start_time'])) : NULL,
                   'end_date' => isset($rowData['end_date']) && !empty($rowData['end_date']) ? date('Y-m-d', strtotime($rowData['end_date'])) : NULL,
                   'end_time' => isset($rowData['end_time']) && !empty($rowData['end_time']) ? date('H:i:s', strtotime($rowData['end_time'])) : NULL, // Handle end_time
                    'compliance_date' => $compliance_date,
                    'due_date' => $rowData['due_date'] ?? NULL,
                    'main_folder_id' => $rowData['main_folder_id'] ?? NULL,
                    'year_folder_id' => $rowData['year_folder_id'] ?? NULL,
                    'month_folder_id' => $rowData['month_folder_id'] ?? NULL,
                    'current_status' => $rowData['current_status'] ?? NULL,
                    // 'amended_by' => $amended_by,
                    'reminder_status' => $reminder_status,
                    // 'reminder_count' => $rowData['reminder_count'] ?? 0,
                    // 'running_status' => $rowData['running_status'] ?? NULL,
                    'status' => $rowData['status'] ?? NULL,
                    'created_at' => $rowData['created_at'] ?? NULL,
                    'updated_at' => $rowData['updated_at'] ?? NULL
                ]); 

                    // task document is not creating may id is not working 
                    // rest of the excel sheet is working fine
                    //below code is for create task document because document are in differet table 
                    // start from here--------------------------------------------------
                    $original_task_id = $rowData['id'];
                    $documents = TaskDocument::where('task_id', $original_task_id)->get();
                    foreach($documents as $document){
                        TaskDocument::create([
                            'task_id' => $new_task->id,
                            'file' => $document->file,
                            'file_original_name' => $document->file_original_name,
                            'file_path' => $document->file_path
                        ]);
                    }
                    // ends here--------------------------------------------------------------------
            }
            return back()->with('csv_imported', 'CSV data has been uploaded successfully!');
        }catch(\Exception $e){
            // return $e->getMessage();  
            return back()->with([
                'error_accrued' => 'An error occurred during the import: ' . $e->getMessage(),
            ]);
        }
    }
}
