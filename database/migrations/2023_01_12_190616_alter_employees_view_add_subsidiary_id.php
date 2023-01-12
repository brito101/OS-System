<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterEmployeesViewAddSubsidiaryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `employees_view` AS
        SELECT e.id, e.name, e.role, e.cell, e.email, e.salary, e.genre, s.alias_name as subsidiary_name, s.id as subsidiary_id
        FROM employees as e
        LEFT JOIN subsidiaries s ON s.id = e.subsidiary_id
        WHERE e.deleted_at IS NULL AND s.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `employees_view` AS
        SELECT e.id, e.name, e.role, e.cell, e.email, e.salary, e.genre, s.alias_name as subsidiary_name
        FROM employees as e
        LEFT JOIN subsidiaries s ON s.id = e.subsidiary_id
        WHERE e.deleted_at IS NULL
        ");
    }
}
