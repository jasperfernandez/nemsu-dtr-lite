<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_day_id')->constrained('attendance_days');
            $table->dateTime('first_in');
            $table->dateTime('last_out');
            $table->integer('late_minutes');
            $table->integer('undertime_minutes');
            $table->integer('work_minutes');
            $table->integer('overtime_minutes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_summaries');
    }
};
