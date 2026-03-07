<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_day_id')->constrained('attendance_days');
            $table->foreignId('employee_id')->constrained('employees');
            $table->dateTime('log_time');
            $table->string('type');
            $table->string('ip_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_logs');
    }
};
