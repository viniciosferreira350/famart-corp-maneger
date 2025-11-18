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
        // users.equipe_id -> equipes.id (nullable)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'equipe_id')) {
                return;
            }

            $table->foreign('equipe_id')
                ->references('id')
                ->on('equipes')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        // equipes.gestor_id -> users.id (nullable)
        Schema::table('equipes', function (Blueprint $table) {
            if (!Schema::hasColumn('equipes', 'gestor_id')) {
                return;
            }

            $table->foreign('gestor_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        // celulares.consultor_id -> users.id
        // celulares.equipe_id -> equipes.id
        Schema::table('celulares', function (Blueprint $table) {
            if (Schema::hasColumn('celulares', 'consultor_id')) {
                $table->foreign('consultor_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }

            if (Schema::hasColumn('celulares', 'equipe_id')) {
                $table->foreign('equipe_id')
                    ->references('id')
                    ->on('equipes')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }
        });

        // whatsapp_numeros foreign keys
        Schema::table('whatsapp_numeros', function (Blueprint $table) {
            if (Schema::hasColumn('whatsapp_numeros', 'celular_id')) {
                $table->foreign('celular_id')
                    ->references('id')
                    ->on('celulares')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }

            if (Schema::hasColumn('whatsapp_numeros', 'consultor_id')) {
                $table->foreign('consultor_id')
                    ->references('id')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }

            if (Schema::hasColumn('whatsapp_numeros', 'equipe_id')) {
                $table->foreign('equipe_id')
                    ->references('id')
                    ->on('equipes')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_numeros', function (Blueprint $table) {
            if (Schema::hasColumn('whatsapp_numeros', 'celular_id')) {
                $table->dropForeign(['celular_id']);
            }
            if (Schema::hasColumn('whatsapp_numeros', 'consultor_id')) {
                $table->dropForeign(['consultor_id']);
            }
            if (Schema::hasColumn('whatsapp_numeros', 'equipe_id')) {
                $table->dropForeign(['equipe_id']);
            }
        });

        Schema::table('celulares', function (Blueprint $table) {
            if (Schema::hasColumn('celulares', 'consultor_id')) {
                $table->dropForeign(['consultor_id']);
            }
            if (Schema::hasColumn('celulares', 'equipe_id')) {
                $table->dropForeign(['equipe_id']);
            }
        });

        Schema::table('equipes', function (Blueprint $table) {
            if (Schema::hasColumn('equipes', 'gestor_id')) {
                $table->dropForeign(['gestor_id']);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'equipe_id')) {
                $table->dropForeign(['equipe_id']);
            }
        });
    }
};
