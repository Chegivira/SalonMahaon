<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->id()->comment('Идентификатор клиентов');
            $table->string('name', 100)->comment('Имя клиента');
            $table->string('surename', 100)->comment('Фамилия клиента');
            $table->string('patronymic', 100)->nullable()->comment('Отчество клиента');
            $table->string('phone', 50)->comment('Телефон клиента');
            $table->string('email', 100)->unique()->comment('Электронная почта клиента');
            $table->string('password')->comment('Пароль клиента');
            $table->rememberToken()->comment('Токен для запоминания клиента');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

