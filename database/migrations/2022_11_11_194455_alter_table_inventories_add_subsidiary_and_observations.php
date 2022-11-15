<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInventoriesAddSubsidiaryAndObservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('job')->nullable();
            $table->text('observations')->nullable();
            $table->text('liberator')->nullable();
            $table->text('stripper')->nullable();
            $table->text('lecturer')->nullable();
            $table->foreignId('subsidiary_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('provider_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['observations', 'job', 'liberator', 'stripper', 'lecturer', 'photo']);
            $table->dropConstrainedForeignId('subsidiary_id');
            $table->dropConstrainedForeignId('provider_id');
        });
    }
}
