<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subsidiary_id')->constrained()->onDelete('cascade');
            $table->string('job');
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->string('number_series')->nullable();
            $table->string('invoice')->nullable();
            $table->decimal('amount', 11, 2)->default(0);
            $table->decimal('value', 11, 2)->default(0);
            $table->string('requester')->nullable();
            $table->date('forecast')->nullable();
            $table->string('authorized')->nullable();
            $table->date('authorized_date')->nullable();
            $table->string('freight')->nullable();
            $table->string('purchase_mode')->nullable();
            $table->string('status')->default('não executada');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}
