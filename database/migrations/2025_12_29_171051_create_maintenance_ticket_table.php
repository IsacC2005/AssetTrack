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
        Schema::create('maintenance_ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('employees', 'id')->onDelete('restrict')->onUpdate('cascade');
            $table->text('failure_device_description')->nullable();
            $table->enum('state', ['pending', 'discarded', 'rejected', 'done']);
            $table->date('date_maintenance')->nullable();
            $table->text('failure')->nullable();
            $table->float('parts_cost')->nullable();
            $table->integer('idle_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_ticket');
    }
};
