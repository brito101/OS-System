<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructionBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('construction_budgets', function (Blueprint $table) {
            $table->id();
            for ($i = 1; $i <= 33; $i++) {
                $table->decimal("item_{$i}_qtd", 11, 2)->nullable()->default(0);
                $table->decimal("item_{$i}_tax", 11, 2)->nullable()->default(0);
                $table->decimal("item_{$i}_total_tax", 11, 2)->nullable()->default(0);
            }
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('construction_budgets');
    }
}
