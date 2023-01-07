<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableClientsAddFunnelParameters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('contact_function')->nullable();
            $table->decimal('value_per_apartment')->nullable();
            $table->decimal('total_value')->nullable();
            $table->date('meeting')->nullable();
            $table->string('status_sale')->nullable();
            $table->string('reason_refusal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['contact_function', 'value_per_apartment', 'total_value', 'meeting', 'status_sale', 'reason_refusal']);
        });
    }
}
