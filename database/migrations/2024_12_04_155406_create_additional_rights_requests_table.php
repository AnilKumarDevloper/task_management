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
        Schema::create('additional_rights_requests', function (Blueprint $table) {
            $table->id();
            $table->Text('request_number')->nullable();
            $table->unsignedBigInteger('raised_by')->nullable();
            $table->Text('reason')->nullable();
            $table->Text('file')->nullable();
            $table->Text('original_file_name')->nullable();
            $table->Text('file_url')->nullable();
            $table->dateTime('resolution_date')->nullable();
            $table->tinyInteger('resolution_status')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('additional_rights_requests');
    }
};
