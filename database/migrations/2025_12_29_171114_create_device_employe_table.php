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
        // Schema::create('device_employee', function (Blueprint $table) {
        //     $table->foreignId('device_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
        //     $table->foreignId('employee_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('device_employee');
    }
};
