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
        Schema::create('appointment', function (Blueprint $table) {
            $table->id()->comment('Идентификатор записи');
            $table->foreignId('client_id')->constrained('users')->comment('ID клиента');
            $table->foreignId('master_id')->constrained('users')->comment('ID мастера');
            $table->foreignId('service_id')->constrained('services')->comment('ID услуги');
            $table->dateTime('date_time')->comment('Дата и время записи');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment');
    }
};
