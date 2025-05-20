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
        Schema::create('employee', function (Blueprint $table) {
            $table->id()->comment('Идентификатор сотрудников');
            $table->foreignId('role_id')->constrained('roles')->comment('ID роли');
            $table->string('name', 100)->comment('Имя сотрудника');
            $table->string('surename', 100)->comment('Фамилия сотрудника');
            $table->string('patronymic', 100)->nullable()->comment('Отчество сотрудника');
            $table->string('email')->unique()->comment('Email сотрудника'); // ← ДОБАВЛЕНО
            $table->string('password')->comment('Пароль сотрудника');
            $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
