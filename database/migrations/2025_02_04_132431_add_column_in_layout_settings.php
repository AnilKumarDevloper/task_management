<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::table('layout_settings', function (Blueprint $table) {
            $table->Text('menu_text_color')->nullable()->after('footer_text_color');
            $table->Text('menu_hover_bg_color')->nullable()->after('menu_text_color');
            $table->Text('menu_hover_text_color')->nullable()->after('menu_hover_bg_color');
            $table->Text('user_name_text_color')->nullable()->after('menu_hover_text_color');
            $table->Text('active_menu_bg_color')->nullable()->after('user_name_text_color');
            $table->Text('active_menu_text_color')->nullable()->after('active_menu_bg_color');
            $table->Text('submenu_list_bg_color')->nullable()->after('active_menu_text_color');
            $table->Text('submenu_text_color')->nullable()->after('submenu_list_bg_color');
            $table->Text('submenu_hover_bg_color')->nullable()->after('submenu_text_color');
            $table->Text('submenu_hover_text_color')->nullable()->after('submenu_hover_bg_color');
            $table->Text('notification_icon_color')->nullable()->after('submenu_hover_text_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layout_settings', function (Blueprint $table) {
            //
        });
    }
};
