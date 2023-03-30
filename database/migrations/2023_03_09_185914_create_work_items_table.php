<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->string('unity')->default('UN');
            $table->string('category')->nullable();
            $table->decimal('value', 11, 2)->default(0);
            $table->decimal('tax', 11, 2)->default(0);
            $table->decimal('commercial', 11, 2)->default(0);
            $table->decimal('fee', 11, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_items');
    }
}
