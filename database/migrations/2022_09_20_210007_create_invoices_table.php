<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subsidiary_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('category')->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type');
            $table->decimal('value', 11, 2);
            $table->date('due_date');
            $table->string('repetition')->default('única'); //uníca, mensal, anual
            $table->integer('quota')->default(1);
            $table->string('status')->default('pendente');
            $table->string('purchase_mode')->nullable();
            $table->text('annotation')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
