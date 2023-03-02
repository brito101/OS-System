<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('telephone')->nullable();

            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->longText('description')->nullable();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->date('execution_date');
            $table->string('priority')->default('Baixa');
            $table->string('status')->default('Não iniciado');
            $table->date('deadline')->nullable();
            $table->string('appraisal')->default('Não avaliado');
            $table->longText('observations')->nullable();
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
        Schema::dropIfExists('service_orders');
    }
}
