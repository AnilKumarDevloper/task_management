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
            $table->Text('logo_sub_heading_color')->nullable()->after('logo_text_color');
            $table->Text('logo_sub_heading_text')->nullable()->after('logo_sub_heading_color');
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
