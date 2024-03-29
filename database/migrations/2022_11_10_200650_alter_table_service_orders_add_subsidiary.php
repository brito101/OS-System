<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableServiceOrdersAddSubsidiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->foreignId('subsidiary_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subsidiary_id');
        });
    }
}
