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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ticket_number')->nullable();
            $table->bigInteger('raised_by')->nullable();
            $table->Text('question')->nullable();
            $table->Text('file')->nullable();
            $table->Text('file_url')->nullable();  
            $table->dateTime('resolution_date')->nullable();    
            $table->tinyInteger('resolution_status')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
