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
    Schema::create('services', function (Blueprint $table) {
        $table->id()->comment('Идентификатор услуги');
        $table->string('name', 100)->comment('Название услуги');
        $table->text('description')->comment('Описание услуги');
        $table->decimal('price', 10, 2)->comment('Стоимость услуги');
        $table->integer('duration')->comment('Длительность услуги в минутах');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
