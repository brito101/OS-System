<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias_name')->nullable();
            $table->string('genre')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('photo')->nullable();
            /** Documents */
            $table->string('document_primary')->nullable();
            $table->string('document_secondary')->nullable();
            $table->string('driver_license')->nullable();
            $table->string('voter_registration')->nullable();
            /** contact */
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('cell')->nullable();
            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            /** Social */
            $table->string('marital_status')->nullable();
            $table->string('spouse')->nullable();
            $table->integer('sons')->nullable();
            /** Bank data */
            $table->string('bank')->nullable();
            $table->string('agency')->nullable();
            $table->string('account')->nullable();
            /** Employment data */
            $table->string('role')->nullable();
            $table->decimal('salary')->nullable();
            $table->date('admission_date')->nullable();
            $table->date('resignation_date')->nullable();
            $table->text('reason_dismissal')->nullable();
            /** Subsidiary */
            $table->foreignId('subsidiary_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            /** Editor */
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
}
