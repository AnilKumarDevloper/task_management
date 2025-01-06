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
        Schema::create('month_folders', function (Blueprint $table) {
            $table->id();
            $table->Text('name')->nullable();
            $table->Text('label')->nullable();
            $table->unsignedBigInteger('main_folder_id')->nullable();
            $table->unsignedBigInteger('year_folder_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('month_folders');
    }
};
