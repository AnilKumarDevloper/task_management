<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        "bg_image",
        "bg_image_path",
        "bg_image_original_name",
        "logo_image",
        "logo_image_path",
        "logo_image_original_name",
        "navbar_color",
        "sidebar_color",
        "logo_text",
        "logo_text_color",
        "logo_text_size",
        "footer_text",
        "footer_text_size",
        "footer_text_color",
        "logo_sub_heading_color",
        "logo_sub_heading_text",

        "menu_text_color",
        "menu_hover_bg_color",
        "menu_hover_text_color",
        "user_name_text_color",
        "active_menu_bg_color",
        "active_menu_text_color",
        "submenu_list_bg_color",
        "submenu_text_color",
        "submenu_hover_bg_color",
        "submenu_hover_text_color",
        "notification_icon_color",
    ];
}
