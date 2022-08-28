<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('social_name');
            $table->string('alias_name');
            $table->string('document_company')->nullable();
            $table->string('document_company_secondary')->nullable();
            $table->string('activity')->nullable();
            /** contact */
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('cell')->nullable();
            $table->string('contact')->nullable();
            $table->string('function')->nullable();
            /** Information */
            $table->string('average_delivery_time')->nullable();
            $table->string('payment_conditions')->nullable();
            $table->string('discounts')->nullable();
            $table->string('products_offered')->nullable();
            $table->string('promotion_funds')->nullable();
            $table->string('technical_assistance')->nullable();
            $table->string('total_purchases_previous_year')->nullable();
            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            /** extra */
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
        Schema::dropIfExists('providers');
    }
}
