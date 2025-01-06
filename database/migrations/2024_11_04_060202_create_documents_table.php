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
        Schema::create('documents', function (Blueprint $table) {
            $table->id(); 
            $table->Text('title')->nullable();
            $table->Text('doc_file')->nullable();
            $table->Text('doc_path')->nullable();
            $table->Text('disk')->nullable();
            $table->bigInteger('main_folder_id')->nullable();
            $table->bigInteger('year_folder_id')->nullable();
            $table->bigInteger('month_folder_id')->nullable();
            $table->bigInteger('uploaded_by')->nullable();
            $table->bigInteger('status')->default(1); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
