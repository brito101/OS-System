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
            $table->string('floor_number')->nullable();
            $table->string('unit_floor')->nullable();
            $table->string('meter_unit')->nullable();
            $table->string('meter_common_area')->nullable();
            $table->string('reading_company')->nullable();
            $table->string('reading_method')->nullable();
            $table->year('year_installation')->nullable();
            $table->string('meter_location')->nullable();
        });

        Schema::table('service_orders', function (Blueprint $table) {
            $table->string('management_measurement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['floor_number', 'unit_floor', 'meter_unit', 'meter_common_area', 'reading_company', 'reading_method', 'year_installation', 'meter_location']);
        });

        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropColumn('management_measurement');
        });
    }
};
