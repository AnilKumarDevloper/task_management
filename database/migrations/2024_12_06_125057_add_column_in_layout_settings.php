<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('layout_settings', function (Blueprint $table) {
            $table->Text('logo_image')->nullable()->after('bg_image_original_name');
            $table->Text('logo_image_path')->nullable()->after('logo_image');
            $table->Text('logo_image_original_name')->nullable()->after('logo_image_path');
            $table->Text('navbar_color')->nullable()->after('logo_image_original_name');
            $table->Text('sidebar_color')->nullable()->after('navbar_color');
            $table->Text('logo_text')->nullable()->after('sidebar_color');
            $table->Text('logo_text_color')->nullable()->after('logo_text');
            $table->Text('logo_text_size')->nullable()->after('logo_text_color');

            $table->Text('footer_text')->nullable()->after('logo_text_size');
            $table->Text('footer_text_size')->nullable()->after('footer_text');
            $table->Text('footer_text_color')->nullable()->after('footer_text_size');
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
