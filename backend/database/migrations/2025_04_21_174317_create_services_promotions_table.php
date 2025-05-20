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
    Schema::create('services_promotions', function (Blueprint $table) {
        $table->id()->comment('Идентификатор связи');
        $table->foreignId('service_id')->constrained('services')->comment('ID услуги');
        $table->foreignId('promotion_id')->constrained('promotions')->comment('ID акции');
        $table->dateTime('start_date')->comment('Дата начала акции');
        $table->dateTime('end_date')->comment('Дата конца акции');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_promotions');
    }
};
