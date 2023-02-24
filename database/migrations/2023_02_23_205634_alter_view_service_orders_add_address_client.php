<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterViewServiceOrdersAddAddressClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `service_orders_view` AS
        SELECT so.id, ac.name as activity, cl.name as client, so.user_id, us.name as collaborator, so.priority, so.deadline, so.status, author as author_id, aut.name as author, so.readiness_date, so.number_series, sub.alias_name as subsidiary, so.subsidiary_id, CONCAT(cl.street, ', nº ', cl.number, ', ', cl.neighborhood, '. CEP: ', cl.zipcode, '. ', cl.city, '-', cl.state) as address
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
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `service_orders_view` AS
        SELECT so.id, ac.name as activity, cl.name as client, so.user_id, us.name as collaborator, so.priority, so.deadline, so.status, author as author_id, aut.name as author, so.readiness_date, so.number_series, sub.alias_name as subsidiary, so.subsidiary_id
        FROM service_orders as so
        LEFT JOIN activities ac ON ac.id = so.activity_id
        LEFT JOIN clients cl ON cl.id = so.client_id
        LEFT JOIN users us ON us.id = so.user_id
        LEFT JOIN users aut ON aut.id = so.author
        LEFT JOIN subsidiaries sub ON sub.id = so.subsidiary_id
        WHERE so.deleted_at IS NULL
        ");
    }
}
