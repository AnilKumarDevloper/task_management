<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\FinancialYearList;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FinancialYearListController extends Controller{
    public function index(){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $years = FinancialYearList::where('status', 1)->orderBy('id', 'desc')->paginate(20);
            return view('backend.financial_year_list.index', compact('years'));
        }else{
            return view('errors.403');
        }
    }
    public function create(){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            return view('backend.financial_year_list.create');
        }else{
            return view('errors.403');
        }
    }
    public function store(Request $request) {
        $validate = $request->validate([
            "name" => ['required', 'unique:'.FinancialYearList::class]
        ]);
        $output = str_replace(' ', '', $request->name);
        FinancialYearList::create([
            "name" => $output,
            "status" => 1
        ]);
        return redirect()->route('backend.fy_year.index')->with('created', 'Financial year has been added.');
    }
    public function edit($id){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $decrypt_id = Crypt::decrypt($id);
            $year = FinancialYearList::where('id', $decrypt_id)->first();
            return view('backend.financial_year_list.edit', compact('year'));
        }else{
            return view('errors.403');
        }
    }
    public function update(Request $request){
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
        $validate = $request->validate([
            "name" => ['required', Rule::unique('financial_year_lists')->ignore($request->id)]
        ]);
        $output = str_replace(' ', '', $request->name); 
        FinancialYearList::where('id', $request->id)->update([
            "name" => $output,
            "status" => 1
        ]);
        return redirect()->route('backend.fy_year.index')->with('updated', 'Financial year has been updated.');
        }else{
            return view('errors.403');
        }
    }
}
