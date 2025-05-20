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
    Schema::create('promotions', function (Blueprint $table) {
        $table->id()->comment('Идентификатор акции');
        $table->string('name', 255)->comment('Название акции');
        $table->text('description')->comment('Описание акции');
        $table->integer('discount_price')->comment('Цена по акции');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
