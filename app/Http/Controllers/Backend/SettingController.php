<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\LayoutSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function layoutColor(){
        $layout_setting = LayoutSetting::where('id', 1)->first();
        return view('backend.setting.layout_setting', compact('layout_setting'));
    }

    public function updateLayoutSetting(Request $request){
        if($request->hasFile('bg_image')){
            $bg_image = $request->file('bg_image');
            $originalName = $bg_image->getClientOriginalName();  
            $extension = $bg_image->getClientOriginalExtension(); 
            $bg_image_name = time() . '.' . $extension;  
            $bg_image_path = 'layout/bg_image';
            $bg_image->move($bg_image_path, $bg_image_name);
            LayoutSetting::where('id', 1)->update([
                'bg_image' => $bg_image_name,
                'bg_image_path' => $bg_image_path,
                'bg_image_original_name' => $originalName
            ]);
        }
        if($request->hasFile('site_logo')){
            $logo_image = $request->file('site_logo');
            $originalName = $logo_image->getClientOriginalName();  
            $extension = $logo_image->getClientOriginalExtension(); 
            $logo_image_name = time() . '.' . $extension;  
            $logo_image_path = 'layout/site_logo';
            $logo_image->move($logo_image_path, $logo_image_name);
            LayoutSetting::where('id', 1)->update([
                'logo_image' => $logo_image_name,
                'logo_image_path' => $logo_image_path,
                'logo_image_original_name' => $originalName
            ]);
        }

        LayoutSetting::where('id', 1)->update([
            "navbar_color" => $request->navbar_color,
            "sidebar_color" => $request->sidebar_background,
            "logo_text_color" => $request->logo_text_color,
            "footer_text_color" => $request->footer_text_color,
            "logo_sub_heading_color" => $request->sub_logo_text_color, 
            "logo_text" => $request->change_logo_heading_name,
            "logo_sub_heading_text" => $request->change_sub_logo_heading_name,
            "footer_text" => $request->copy_right_text,
        ]);
        
        return redirect()->back()->with('new_updated', 'Layout setting has been updated.');
    }

    public function updateDefaultLayout(Request $request){
        try{
            LayoutSetting::where('id', 1)->update([
                "navbar_color" => "#fafafa",
                "sidebar_color" => "#f2f2f2",
                "logo_text_color" => "#195e90",
                "footer_text_color" => "#ffdbdb",
                "logo_sub_heading_color" => "#9e7400", 
                "logo_text" => "NDM Advisors LLP",
                "logo_sub_heading_text" => "Secretarial Compliance Management (SCM)",
                "footer_text" => "Copyright 2024, Secretarial Compliance Management (SCM) is a proprietory tool and all Rights reserved with NDM Advisors LLP",
            ]);
            return redirect()->back()->with('default_updated', 'Default Layout setting has been updated.');
        }catch(\Exception $e){
            return $e->getMessage();
        }
       

    }


}
