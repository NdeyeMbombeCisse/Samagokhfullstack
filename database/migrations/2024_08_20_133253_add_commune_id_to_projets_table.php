<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // Migration pour supprimer la colonne existante si nécessaire
public function up(): void
{
    Schema::table('projets', function (Blueprint $table) {
        if (Schema::hasColumn('projets', 'commune_id')) {
            $table->dropForeign(['commune_id']);
            $table->dropColumn('commune_id');
        }
    });
}

// Migration pour ajouter la colonne correctement
public function down(): void
{
    Schema::table('projets', function (Blueprint $table) {
        $table->foreignId('commune_id')->constrained('communes')->onDelete('cascade');
    });
}

};
