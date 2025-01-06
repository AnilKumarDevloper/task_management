<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\MainFolder;
use App\Models\Backend\MonthFolder;
use App\Models\Backend\YearFolder;
use App\Models\User;
use Crypt;
use Illuminate\Http\Request;
use App\Models\Backend\{Document};
use Auth;

class DocumentController extends Controller{
    public function index($main_f_id, $year_f_id, $month_f_id){ 
        try{ 
            $decrypt_main_f_id = Crypt::decrypt($main_f_id);
            $decrypt_year_f_id = Crypt::decrypt($year_f_id);
            $decrypt_month_f_id = Crypt::decrypt($month_f_id); 
            $documents = Document::where('main_folder_id', $decrypt_main_f_id)
            ->where('year_folder_id', $decrypt_year_f_id)
            ->where('month_folder_id', $decrypt_month_f_id)->paginate(10); 
            $main_folder = MainFolder::where('id', $decrypt_main_f_id)->first();
            $year_folder = YearFolder::where('id', $decrypt_year_f_id)->first();
            $month_folder = MonthFolder::where('id', $decrypt_month_f_id)->first(); 
            $employees = User::where('role_id', 3)->where('status', 1)->get();
           return view('backend.document.index', compact('documents', 'main_folder',
           'year_folder', 'month_folder', 'employees'));
        }catch(\Exception $e){
            abort('404');
        }
    }
    public function store(Request $request){ 
        $validate = $request->validate([
            'title' => ['max:100'],  
            'document' => ['required', 'mimes:pdf,png,doc,docx,xls,xlsx,xlsm,txt']
        ]);
        $main_f = MainFolder::where('id', $request->main_f_id)->first(); 
        $year_f = YearFolder::where('id', $request->year_f_id)->first();
        $month_f = MonthFolder::where('id', $request->month_f_id)->first();
        $document = Document::create([
            'title' => $request->title,
            'main_folder_id' => $request->main_f_id,
            'year_folder_id' => $request->year_f_id, 
            'month_folder_id' => $request->month_f_id, 
            'uploaded_by' => Auth::user()->id
        ]); 
        if($request->hasFile('document')){
            $documentFile = $request->file('document');
            $extension = $documentFile->getClientOriginalExtension();
            $documentName = time() . '.' . $extension;  
            $documentPath = public_path('client_data/' . $main_f->name . '/' . $year_f->name .'/' .$month_f->name);
            $documentFile->move($documentPath, $documentName);  
            Document::where('id', $document->id)->update([
                'doc_file' => $documentName,
                'doc_path' => 'public/client_data/' . $main_f->name . '/' . $year_f->name . '/' . $month_f->name
            ]);
        } 
        return redirect()->route('backend.document.index', [Crypt::encrypt($request->main_f_id), Crypt::encrypt($request->year_f_id), Crypt::encrypt($request->month_f_id)])->with('created', 'Document has been uploaded successfully.');
    }
    public function getDocument(Request $request){
        try{
            $document = Document::where('id', $request->doc_id)->first();
            return response()->json([
                "status" => "success",
                "document" => $document
            ]);
        }catch(\Exception $e){
            return response()->json([
                "status" => "failed",
                "error" => $e->getMessage()
            ]);
        }
    }
    public function update(Request $request){
        $validate = $request->validate([
            'title' => ['max:100'],  
            'document' => ['mimes:pdf,png,doc,docx,xls,xlsx,xlsm,txt']
        ]);
        Document::where('id', $request->doc_id)->update([
            "title" => $request->title, 
        ]); 
        if($request->hasFile('document')){
            $main_f = MainFolder::where('id', $request->main_f_id)->first(); 
            $year_f = YearFolder::where('id', $request->year_f_id)->first();
            $month_f = MonthFolder::where('id', $request->month_f_id)->first();
            $documentFile = $request->file('document');
            $extension = $documentFile->getClientOriginalExtension();
            $documentName = time() . '.' . $extension;  
            $documentPath = public_path('client_data/' . $main_f->name . '/' . $year_f->name .'/' .$month_f->name);
            $documentFile->move($documentPath, $documentName);  
            Document::where('id', $request->doc_id)->update([
                'doc_file' => $documentName,
            ]);
        }
        return redirect()->route('backend.document.index', [Crypt::encrypt($request->main_f_id), Crypt::encrypt($request->year_f_id), Crypt::encrypt($request->month_f_id)])->with('updated', 'Document has been updated successfully.');
    }
    public function destroy(Request $request){
        try{ 
            Document::find($request->doc_id)->delete();
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
 
}
