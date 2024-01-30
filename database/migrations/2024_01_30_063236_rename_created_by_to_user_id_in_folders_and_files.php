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
        Schema::table('folders', function (Blueprint $table) {
            $table->renameColumn('created_by', 'user_id');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->renameColumn('created_by', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('folders', function (Blueprint $table) {
            $table->renameColumn('user_id', 'created_by');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->renameColumn('user_id', 'created_by');
        });
    }
};
