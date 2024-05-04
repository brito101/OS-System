<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW `service_orders_view` AS
        SELECT so.id, ac.name as activity, so.type, cl.name as client, so.user_id, us.name as collaborator, so.priority, so.deadline, so.status, author as author_id, aut.name as author, so.readiness_date, so.number_series, sub.alias_name as subsidiary, so.subsidiary_id, CONCAT(so.street, ', nº ', so.number, ', ', so.neighborhood, '. CEP: ', so.zipcode, '. ', so.city, '-', so.state) as address
        FROM service_orders as so
        LEFT JOIN activities ac ON ac.id = so.activity_id
        LEFT JOIN clients cl ON cl.id = so.client_id
        LEFT JOIN users us ON us.id = so.user_id
        LEFT JOIN users aut ON aut.id = so.author 
        LEFT JOIN subsidiaries sub ON sub.id = so.subsidiary_id
        WHERE so.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW `service_orders_view` AS
        SELECT so.id, ac.name as activity, cl.name as client, so.user_id, us.name as collaborator, so.priority, so.deadline, so.status, author as author_id, aut.name as author, so.readiness_date, so.number_series, sub.alias_name as subsidiary, so.subsidiary_id, CONCAT(so.street, ', nº ', so.number, ', ', so.neighborhood, '. CEP: ', so.zipcode, '. ', so.city, '-', so.state) as address
        FROM service_orders as so
        LEFT JOIN activities ac ON ac.id = so.activity_id
        LEFT JOIN clients cl ON cl.id = so.client_id
        LEFT JOIN users us ON us.id = so.user_id
        LEFT JOIN users aut ON aut.id = so.author 
        LEFT JOIN subsidiaries sub ON sub.id = so.subsidiary_id
        WHERE so.deleted_at IS NULL
        ");
    }
};
