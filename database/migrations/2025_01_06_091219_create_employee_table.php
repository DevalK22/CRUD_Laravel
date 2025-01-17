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
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->integer('salary')->nullable();
            $table->string('leave_type')->nullable();
            $table->date('start_leave')->nullable();
            $table->date('end_leave')->nullable();
            $table->string('reason')->nullable();
            $table->enum('status',['Approved','Rejected','Pending'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
