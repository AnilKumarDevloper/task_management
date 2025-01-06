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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->String('doc_file')->nullable();
            $table->String('doc_path')->nullable();
            $table->bigInteger('document_id')->nullable();
            $table->bigInteger('assigned_by')->nullable();
            $table->bigInteger('assigned_to')->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_date')->nullable();
            $table->time('end_time')->nullable();
            $table->bigInteger(column: 'main_folder_id')->nullable();
            $table->bigInteger(column: 'year_folder_id')->nullable();
            $table->bigInteger(column: 'month_folder_id')->nullable();
            $table->String(column: 'current_status')->nullable();
            $table->tinyInteger(column: 'status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
