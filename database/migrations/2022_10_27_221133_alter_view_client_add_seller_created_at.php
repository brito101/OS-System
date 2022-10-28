<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterViewClientAddSellerCreatedAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW `clients_view` AS
        SELECT c.id, c.name, c.email, c.telephone, c.type, s.alias_name, c.subsidiary_id, c.trade_status, c.origin, c.created_at, u.name as seller
        FROM clients c
        LEFT JOIN subsidiaries s ON s.id = c.subsidiary_id
        LEFT JOIN users u ON u.id = c.seller
        WHERE c.deleted_at IS NULL AND s.deleted_at IS NULL
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
        CREATE OR REPLACE VIEW `clients_view` AS
        SELECT c.id, c.name, c.email, c.telephone, c.type, s.alias_name, c.subsidiary_id, c.trade_status, c.origin
        FROM clients c
        LEFT JOIN subsidiaries s ON s.id = c.subsidiary_id
        WHERE c.deleted_at IS NULL AND s.deleted_at IS NULL
        ");
    }
}
