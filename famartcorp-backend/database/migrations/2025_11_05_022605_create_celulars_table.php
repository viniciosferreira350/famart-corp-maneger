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
        Schema::create('celulares', function (Blueprint $table) {
            $table->id();
            $table->string('marca', 50);
            $table->string('modelo', 100);
            $table->string('imei', 20)->nullable()->unique();
            $table->text('observacao')->nullable();
            $table->unsignedBigInteger('consultor_id');
            $table->unsignedBigInteger('equipe_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('celulars');
    }
};
