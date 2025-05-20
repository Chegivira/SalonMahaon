<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('schedule', function (Blueprint $table) {
        $table->id()->comment('Идентификатор графика');
        $table->foreignId('employee_id')->constrained('employee')->comment('ID мастера');
        $table->enum('day', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->comment('День недели');
        $table->time('start_time')->comment('Время начала смены');
        $table->time('end_time')->comment('Время конца смены');
        $table->foreignId('workplace_id')->constrained('workplaces')->comment('ID рабочего места');
        $table->foreignId('shift_id')->constrained('shift')->comment('ID смены');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};
