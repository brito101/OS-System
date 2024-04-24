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
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('blocks')->nullable()->default(0);
            $table->string('type_piping')->nullable();
            $table->string('pipe_diameter')->nullable();
            $table->boolean('pipe_space')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['blocks', 'type_piping', 'pipe_diameter', 'pipe_space']);
        });
    }
};
