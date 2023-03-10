<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('role_has_permissions')->insert([
            /** ACL 1 to  11 */
            [
                'permission_id' => 1,
                'role_id' => 1
            ],
            [
                'permission_id' => 2,
                'role_id' => 1
            ],
            [
                'permission_id' => 3,
                'role_id' => 1
            ],
            [
                'permission_id' => 4,
                'role_id' => 1
            ],
            [
                'permission_id' => 5,
                'role_id' => 1
            ],
            [
                'permission_id' => 6,
                'role_id' => 1
            ],
            [
                'permission_id' => 7,
                'role_id' => 1
            ],
            [
                'permission_id' => 8,
                'role_id' => 1
            ],
            [
                'permission_id' => 9,
                'role_id' => 1
            ],
            [
                'permission_id' => 10,
                'role_id' => 1
            ],
            [
                'permission_id' => 11,
                'role_id' => 1
            ],
            /* Profile assignment by administrator type user */
            [
                'permission_id' => 11,
                'role_id' => 2
            ],

            /** Users 12 to 17 (programmer, administrator, manager) */
            [
                'permission_id' => 12,
                'role_id' => 1
            ],
            [
                'permission_id' => 12,
                'role_id' => 2
            ],
            [
                'permission_id' => 13,
                'role_id' => 1
            ],
            [
                'permission_id' => 13,
                'role_id' => 2
            ],
            [
                'permission_id' => 14,
                'role_id' => 1
            ],
            [
                'permission_id' => 14,
                'role_id' => 2
            ],
            /** Profile */
            [
                'permission_id' => 15,
                'role_id' => 1
            ],
            [
                'permission_id' => 15,
                'role_id' => 2
            ],
            [
                'permission_id' => 15,
                'role_id' => 3
            ],
            [
                'permission_id' => 15,
                'role_id' => 4
            ],
            [
                'permission_id' => 15,
                'role_id' => 5
            ],
            [
                'permission_id' => 15,
                'role_id' => 6
            ],
            [
                'permission_id' => 15,
                'role_id' => 7
            ],
            [
                'permission_id' => 15,
                'role_id' => 8
            ],
            [
                'permission_id' => 15,
                'role_id' => 9
            ],
            [
                'permission_id' => 15,
                'role_id' => 10
            ],
            /** */
            [
                'permission_id' => 16,
                'role_id' => 1
            ],
            [
                'permission_id' => 16,
                'role_id' => 2
            ],
            [
                'permission_id' => 17,
                'role_id' => 1
            ],
            [
                'permission_id' => 17,
                'role_id' => 2
            ],
            /** Activities 18 to 23 (programmer and administrator ) */
            [
                'permission_id' => 18,
                'role_id' => 1
            ],
            [
                'permission_id' => 18,
                'role_id' => 2
            ],
            [
                'permission_id' => 19,
                'role_id' => 1
            ],
            [
                'permission_id' => 19,
                'role_id' => 2
            ],
            [
                'permission_id' => 20,
                'role_id' => 1
            ],
            [
                'permission_id' => 20,
                'role_id' => 2
            ],
            [
                'permission_id' => 21,
                'role_id' => 1
            ],
            [
                'permission_id' => 21,
                'role_id' => 2
            ],
            [
                'permission_id' => 22,
                'role_id' => 1
            ],
            [
                'permission_id' => 22,
                'role_id' => 2
            ],
            /** Subsidiaries 24 to 29 (programmer, administrator ) */
            [
                'permission_id' => 23,
                'role_id' => 1
            ],
            [
                'permission_id' => 23,
                'role_id' => 2
            ],
            [
                'permission_id' => 24,
                'role_id' => 1
            ],
            [
                'permission_id' => 24,
                'role_id' => 2
            ],
            [
                'permission_id' => 25,
                'role_id' => 1
            ],
            [
                'permission_id' => 25,
                'role_id' => 2
            ],
            [
                'permission_id' => 26,
                'role_id' => 1
            ],
            [
                'permission_id' => 26,
                'role_id' => 2
            ],
            [
                'permission_id' => 27,
                'role_id' => 1
            ],
            [
                'permission_id' => 27,
                'role_id' => 2
            ],
            [
                'permission_id' => 28,
                'role_id' => 1
            ],
            [
                'permission_id' => 28,
                'role_id' => 2
            ],
            [
                'permission_id' => 29,
                'role_id' => 1
            ],
            [
                'permission_id' => 29,
                'role_id' => 2
            ],
            /** Clients 30 to 34 (programmer, administrator, managers and collaborators) */
            [
                'permission_id' => 30,
                'role_id' => 1
            ],
            [
                'permission_id' => 30,
                'role_id' => 2
            ],
            [
                'permission_id' => 30,
                'role_id' => 3
            ],
            [
                'permission_id' => 30,
                'role_id' => 4
            ],
            [
                'permission_id' => 30,
                'role_id' => 7
            ],
            [
                'permission_id' => 31,
                'role_id' => 1
            ],
            [
                'permission_id' => 31,
                'role_id' => 2
            ],
            [
                'permission_id' => 31,
                'role_id' => 3
            ],
            [
                'permission_id' => 31,
                'role_id' => 4
            ],
            [
                'permission_id' => 31,
                'role_id' => 7
            ],
            [
                'permission_id' => 32,
                'role_id' => 1
            ],
            [
                'permission_id' => 32,
                'role_id' => 2
            ],
            [
                'permission_id' => 32,
                'role_id' => 3
            ],
            [
                'permission_id' => 32,
                'role_id' => 4
            ],
            [
                'permission_id' => 32,
                'role_id' => 7
            ],
            [
                'permission_id' => 33,
                'role_id' => 1
            ],
            [
                'permission_id' => 33,
                'role_id' => 2
            ],
            [
                'permission_id' => 33,
                'role_id' => 3
            ],
            [
                'permission_id' => 33,
                'role_id' => 4
            ],
            [
                'permission_id' => 33,
                'role_id' => 7
            ],
            [
                'permission_id' => 34,
                'role_id' => 1
            ],
            [
                'permission_id' => 34,
                'role_id' => 2
            ],
            [
                'permission_id' => 34,
                'role_id' => 3
            ],
            [
                'permission_id' => 34,
                'role_id' => 4
            ],
            [
                'permission_id' => 34,
                'role_id' => 7
            ],
            /** Service Orders 35 to 39 (programmer, administrator, managers, collaborator, readers, maintenance ) */
            [
                'permission_id' => 35,
                'role_id' => 1
            ],
            [
                'permission_id' => 35,
                'role_id' => 2
            ],
            [
                'permission_id' => 35,
                'role_id' => 3
            ],
            [
                'permission_id' => 35,
                'role_id' => 4
            ],
            [
                'permission_id' => 35,
                'role_id' => 7
            ],
            [
                'permission_id' => 35,
                'role_id' => 8
            ],
            [
                'permission_id' => 35,
                'role_id' => 9
            ],
            [
                'permission_id' => 35,
                'role_id' => 10
            ],
            [
                'permission_id' => 36,
                'role_id' => 1
            ],
            [
                'permission_id' => 36,
                'role_id' => 2
            ],
            [
                'permission_id' => 36,
                'role_id' => 3
            ],
            [
                'permission_id' => 36,
                'role_id' => 4
            ],
            [
                'permission_id' => 36,
                'role_id' => 7
            ],
            [
                'permission_id' => 36,
                'role_id' => 8
            ],
            [
                'permission_id' => 36,
                'role_id' => 9
            ],
            [
                'permission_id' => 36,
                'role_id' => 10
            ],
            [
                'permission_id' => 37,
                'role_id' => 1
            ],
            [
                'permission_id' => 37,
                'role_id' => 2
            ],
            [
                'permission_id' => 37,
                'role_id' => 3
            ],
            [
                'permission_id' => 37,
                'role_id' => 4
            ],
            [
                'permission_id' => 37,
                'role_id' => 7
            ],
            [
                'permission_id' => 37,
                'role_id' => 8
            ],
            [
                'permission_id' => 37,
                'role_id' => 9
            ],
            [
                'permission_id' => 37,
                'role_id' => 10
            ],
            [
                'permission_id' => 38,
                'role_id' => 1
            ],
            [
                'permission_id' => 38,
                'role_id' => 2
            ],
            [
                'permission_id' => 38,
                'role_id' => 3
            ],
            [
                'permission_id' => 38,
                'role_id' => 4
            ],
            [
                'permission_id' => 38,
                'role_id' => 7
            ],
            [
                'permission_id' => 38,
                'role_id' => 8
            ],
            [
                'permission_id' => 38,
                'role_id' => 9
            ],
            [
                'permission_id' => 38,
                'role_id' => 10
            ],
            [
                'permission_id' => 39,
                'role_id' => 1
            ],
            [
                'permission_id' => 39,
                'role_id' => 2
            ],
            [
                'permission_id' => 39,
                'role_id' => 3
            ],
            [
                'permission_id' => 39,
                'role_id' => 4
            ],
            [
                'permission_id' => 39,
                'role_id' => 7
            ],
            [
                'permission_id' => 39,
                'role_id' => 8
            ],
            [
                'permission_id' => 39,
                'role_id' => 9
            ],
            [
                'permission_id' => 39,
                'role_id' => 10
            ],
            /** List Managers 40 (programmer, administrator ) */
            [
                'permission_id' => 40,
                'role_id' => 1
            ],
            [
                'permission_id' => 40,
                'role_id' => 2
            ],
            /** Providers 41 to 45 (programmer, administrator, (manager, collaborators => (access and list))) */
            [
                'permission_id' => 41,
                'role_id' => 1
            ],
            [
                'permission_id' => 41,
                'role_id' => 2
            ],
            [
                'permission_id' => 41,
                'role_id' => 3
            ],
            [
                'permission_id' => 41,
                'role_id' => 4
            ],
            [
                'permission_id' => 41,
                'role_id' => 7
            ],
            [
                'permission_id' => 42,
                'role_id' => 1
            ],
            [
                'permission_id' => 42,
                'role_id' => 2
            ],
            [
                'permission_id' => 42,
                'role_id' => 3
            ],
            [
                'permission_id' => 42,
                'role_id' => 4
            ],
            [
                'permission_id' => 42,
                'role_id' => 7
            ],
            [
                'permission_id' => 43,
                'role_id' => 1
            ],
            [
                'permission_id' => 43,
                'role_id' => 2
            ],
            [
                'permission_id' => 44,
                'role_id' => 1
            ],
            [
                'permission_id' => 44,
                'role_id' => 2
            ],
            [
                'permission_id' => 45,
                'role_id' => 1
            ],
            [
                'permission_id' => 45,
                'role_id' => 2
            ],
            /** Finance 46 (programmer, administrator, managers, financial) */
            [
                'permission_id' => 46,
                'role_id' => 1
            ],
            [
                'permission_id' => 46,
                'role_id' => 2
            ],
            [
                'permission_id' => 46,
                'role_id' => 3
            ],
            [
                'permission_id' => 46,
                'role_id' => 5
            ],
            /** Incomes 47 to 51 (programmer, administrator, managers, financial) */
            [
                'permission_id' => 47,
                'role_id' => 1
            ],
            [
                'permission_id' => 47,
                'role_id' => 2
            ],
            [
                'permission_id' => 47,
                'role_id' => 3
            ],
            [
                'permission_id' => 47,
                'role_id' => 5
            ],
            [
                'permission_id' => 48,
                'role_id' => 1
            ],
            [
                'permission_id' => 48,
                'role_id' => 2
            ],
            [
                'permission_id' => 48,
                'role_id' => 3
            ],
            [
                'permission_id' => 48,
                'role_id' => 5
            ],
            [
                'permission_id' => 49,
                'role_id' => 1
            ],
            [
                'permission_id' => 49,
                'role_id' => 2
            ],
            [
                'permission_id' => 49,
                'role_id' => 3
            ],
            [
                'permission_id' => 49,
                'role_id' => 5
            ],
            [
                'permission_id' => 50,
                'role_id' => 1
            ],
            [
                'permission_id' => 50,
                'role_id' => 2
            ],
            [
                'permission_id' => 50,
                'role_id' => 3
            ],
            [
                'permission_id' => 50,
                'role_id' => 5
            ],
            [
                'permission_id' => 51,
                'role_id' => 1
            ],
            [
                'permission_id' => 51,
                'role_id' => 2
            ],
            [
                'permission_id' => 51,
                'role_id' => 3
            ],
            [
                'permission_id' => 51,
                'role_id' => 5
            ],
            /** Expenses 52 to 56 (programmer, administrator, managers, financial) */
            [
                'permission_id' => 52,
                'role_id' => 1
            ],
            [
                'permission_id' => 52,
                'role_id' => 2
            ],
            [
                'permission_id' => 52,
                'role_id' => 3
            ],
            [
                'permission_id' => 52,
                'role_id' => 5
            ],
            [
                'permission_id' => 53,
                'role_id' => 1
            ],
            [
                'permission_id' => 53,
                'role_id' => 2
            ],
            [
                'permission_id' => 53,
                'role_id' => 3
            ],
            [
                'permission_id' => 53,
                'role_id' => 5
            ],
            [
                'permission_id' => 54,
                'role_id' => 1
            ],
            [
                'permission_id' => 54,
                'role_id' => 2
            ],
            [
                'permission_id' => 54,
                'role_id' => 3
            ],
            [
                'permission_id' => 54,
                'role_id' => 5
            ],
            [
                'permission_id' => 55,
                'role_id' => 1
            ],
            [
                'permission_id' => 55,
                'role_id' => 2
            ],
            [
                'permission_id' => 55,
                'role_id' => 3
            ],
            [
                'permission_id' => 55,
                'role_id' => 5
            ],
            [
                'permission_id' => 56,
                'role_id' => 1
            ],
            [
                'permission_id' => 56,
                'role_id' => 2
            ],
            [
                'permission_id' => 56,
                'role_id' => 3
            ],
            [
                'permission_id' => 56,
                'role_id' => 5
            ],
            /** Refunds 57 to 61 (programmer, administrator, managers, financial) */
            [
                'permission_id' => 57,
                'role_id' => 1
            ],
            [
                'permission_id' => 57,
                'role_id' => 2
            ],
            [
                'permission_id' => 57,
                'role_id' => 3
            ],
            [
                'permission_id' => 57,
                'role_id' => 5
            ],
            [
                'permission_id' => 58,
                'role_id' => 1
            ],
            [
                'permission_id' => 58,
                'role_id' => 2
            ],
            [
                'permission_id' => 58,
                'role_id' => 3
            ],
            [
                'permission_id' => 58,
                'role_id' => 5
            ],
            [
                'permission_id' => 59,
                'role_id' => 1
            ],
            [
                'permission_id' => 59,
                'role_id' => 2
            ],
            [
                'permission_id' => 59,
                'role_id' => 3
            ],
            [
                'permission_id' => 59,
                'role_id' => 5
            ],
            [
                'permission_id' => 60,
                'role_id' => 1
            ],
            [
                'permission_id' => 60,
                'role_id' => 2
            ],
            [
                'permission_id' => 60,
                'role_id' => 3
            ],
            [
                'permission_id' => 60,
                'role_id' => 5
            ],
            [
                'permission_id' => 61,
                'role_id' => 1
            ],
            [
                'permission_id' => 61,
                'role_id' => 2
            ],
            [
                'permission_id' => 61,
                'role_id' => 3
            ],
            [
                'permission_id' => 61,
                'role_id' => 5
            ],
            /** List Managers 62 (programmer, administrator ) */
            [
                'permission_id' => 62,
                'role_id' => 1
            ],
            [
                'permission_id' => 62,
                'role_id' => 2
            ],
            /** Purchase Orders 63 to 67 (programmer, administrator, managers, financiers) */
            [
                'permission_id' => 63,
                'role_id' => 1
            ],
            [
                'permission_id' => 63,
                'role_id' => 2
            ],
            [
                'permission_id' => 63,
                'role_id' => 3
            ],
            [
                'permission_id' => 63,
                'role_id' => 5
            ],
            [
                'permission_id' => 64,
                'role_id' => 1
            ],
            [
                'permission_id' => 64,
                'role_id' => 2
            ],
            [
                'permission_id' => 64,
                'role_id' => 3
            ],
            [
                'permission_id' => 64,
                'role_id' => 5
            ],
            [
                'permission_id' => 65,
                'role_id' => 1
            ],
            [
                'permission_id' => 65,
                'role_id' => 2
            ],
            [
                'permission_id' => 65,
                'role_id' => 3
            ],
            [
                'permission_id' => 65,
                'role_id' => 5
            ],
            [
                'permission_id' => 66,
                'role_id' => 1
            ],
            [
                'permission_id' => 66,
                'role_id' => 2
            ],
            [
                'permission_id' => 66,
                'role_id' => 3
            ],
            [
                'permission_id' => 66,
                'role_id' => 5
            ],
            [
                'permission_id' => 67,
                'role_id' => 1
            ],
            [
                'permission_id' => 67,
                'role_id' => 2
            ],
            [
                'permission_id' => 67,
                'role_id' => 3
            ],
            [
                'permission_id' => 67,
                'role_id' => 5
            ],
            /** Priducts 68 to 72 (programmer, administrator, managers, stockist) */
            [
                'permission_id' => 68,
                'role_id' => 1
            ],
            [
                'permission_id' => 68,
                'role_id' => 2
            ],
            [
                'permission_id' => 68,
                'role_id' => 3
            ],
            [
                'permission_id' => 68,
                'role_id' => 6
            ],
            [
                'permission_id' => 69,
                'role_id' => 1
            ],
            [
                'permission_id' => 69,
                'role_id' => 2
            ],
            [
                'permission_id' => 69,
                'role_id' => 3
            ],
            [
                'permission_id' => 69,
                'role_id' => 6
            ],
            [
                'permission_id' => 70,
                'role_id' => 1
            ],
            [
                'permission_id' => 70,
                'role_id' => 2
            ],
            [
                'permission_id' => 70,
                'role_id' => 3
            ],
            [
                'permission_id' => 70,
                'role_id' => 6
            ],
            [
                'permission_id' => 71,
                'role_id' => 1
            ],
            [
                'permission_id' => 71,
                'role_id' => 2
            ],
            [
                'permission_id' => 71,
                'role_id' => 3
            ],
            [
                'permission_id' => 71,
                'role_id' => 6
            ],
            [
                'permission_id' => 72,
                'role_id' => 1
            ],
            [
                'permission_id' => 72,
                'role_id' => 2
            ],
            [
                'permission_id' => 72,
                'role_id' => 3
            ],
            [
                'permission_id' => 72,
                'role_id' => 6
            ],
            /** Stocks 73 to 76 (programmer, administrator, managers, stockist) */
            [
                'permission_id' => 73,
                'role_id' => 1
            ],
            [
                'permission_id' => 73,
                'role_id' => 2
            ],
            [
                'permission_id' => 73,
                'role_id' => 3
            ],
            [
                'permission_id' => 73,
                'role_id' => 6
            ],
            [
                'permission_id' => 74,
                'role_id' => 1
            ],
            [
                'permission_id' => 74,
                'role_id' => 2
            ],
            [
                'permission_id' => 74,
                'role_id' => 3
            ],
            [
                'permission_id' => 74,
                'role_id' => 6
            ],
            [
                'permission_id' => 75,
                'role_id' => 1
            ],
            [
                'permission_id' => 75,
                'role_id' => 2
            ],
            [
                'permission_id' => 75,
                'role_id' => 3
            ],
            [
                'permission_id' => 75,
                'role_id' => 6
            ],
            [
                'permission_id' => 76,
                'role_id' => 1
            ],
            [
                'permission_id' => 76,
                'role_id' => 2
            ],
            [
                'permission_id' => 76,
                'role_id' => 3
            ],
            [
                'permission_id' => 76,
                'role_id' => 6
            ],
            /** Commissions 77 to 85 (programmer, administrator, managers, financiers) */
            [
                'permission_id' => 77,
                'role_id' => 1
            ],
            [
                'permission_id' => 77,
                'role_id' => 2
            ],
            [
                'permission_id' => 77,
                'role_id' => 3
            ],
            [
                'permission_id' => 77,
                'role_id' => 5
            ],
            [
                'permission_id' => 78,
                'role_id' => 1
            ],
            [
                'permission_id' => 78,
                'role_id' => 2
            ],
            [
                'permission_id' => 78,
                'role_id' => 3
            ],
            [
                'permission_id' => 78,
                'role_id' => 5
            ],
            [
                'permission_id' => 79,
                'role_id' => 1
            ],
            [
                'permission_id' => 79,
                'role_id' => 2
            ],
            [
                'permission_id' => 79,
                'role_id' => 3
            ],
            [
                'permission_id' => 79,
                'role_id' => 5
            ],
            [
                'permission_id' => 80,
                'role_id' => 1
            ],
            [
                'permission_id' => 80,
                'role_id' => 2
            ],
            [
                'permission_id' => 80,
                'role_id' => 3
            ],
            [
                'permission_id' => 80,
                'role_id' => 5
            ],
            [
                'permission_id' => 81,
                'role_id' => 1
            ],
            [
                'permission_id' => 81,
                'role_id' => 2
            ],
            [
                'permission_id' => 81,
                'role_id' => 3
            ],
            [
                'permission_id' => 81,
                'role_id' => 5
            ],
            [
                'permission_id' => 82,
                'role_id' => 1
            ],
            [
                'permission_id' => 82,
                'role_id' => 2
            ],
            [
                'permission_id' => 82,
                'role_id' => 3
            ],
            [
                'permission_id' => 82,
                'role_id' => 5
            ],
            [
                'permission_id' => 83,
                'role_id' => 1
            ],
            [
                'permission_id' => 83,
                'role_id' => 2
            ],
            [
                'permission_id' => 83,
                'role_id' => 3
            ],
            [
                'permission_id' => 83,
                'role_id' => 5
            ],
            [
                'permission_id' => 84,
                'role_id' => 1
            ],
            [
                'permission_id' => 84,
                'role_id' => 2
            ],
            [
                'permission_id' => 84,
                'role_id' => 3
            ],
            [
                'permission_id' => 84,
                'role_id' => 5
            ],
            [
                'permission_id' => 85,
                'role_id' => 1
            ],
            [
                'permission_id' => 85,
                'role_id' => 2
            ],
            [
                'permission_id' => 85,
                'role_id' => 3
            ],
            [
                'permission_id' => 85,
                'role_id' => 5
            ],
            [
                'permission_id' => 86,
                'role_id' => 1
            ],
            [
                'permission_id' => 86,
                'role_id' => 2
            ],
            [
                'permission_id' => 86,
                'role_id' => 3
            ],
            [
                'permission_id' => 86,
                'role_id' => 5
            ],
            /** Schedules */
            [
                'permission_id' => 87,
                'role_id' => 1
            ],
            [
                'permission_id' => 87,
                'role_id' => 2
            ],
            [
                'permission_id' => 87,
                'role_id' => 3
            ],
            [
                'permission_id' => 87,
                'role_id' => 4
            ],
            [
                'permission_id' => 87,
                'role_id' => 5
            ],
            [
                'permission_id' => 87,
                'role_id' => 6
            ],
            [
                'permission_id' => 87,
                'role_id' => 7
            ],
            [
                'permission_id' => 87,
                'role_id' => 8
            ],
            [
                'permission_id' => 87,
                'role_id' => 9
            ],
            [
                'permission_id' => 87,
                'role_id' => 10
            ],
            [
                'permission_id' => 88,
                'role_id' => 1
            ],
            [
                'permission_id' => 88,
                'role_id' => 2
            ],
            [
                'permission_id' => 88,
                'role_id' => 3
            ],
            [
                'permission_id' => 88,
                'role_id' => 4
            ],
            [
                'permission_id' => 88,
                'role_id' => 5
            ],
            [
                'permission_id' => 88,
                'role_id' => 6
            ],
            [
                'permission_id' => 88,
                'role_id' => 7
            ],
            [
                'permission_id' => 88,
                'role_id' => 8
            ],
            [
                'permission_id' => 88,
                'role_id' => 9
            ],
            [
                'permission_id' => 88,
                'role_id' => 10
            ],
            [
                'permission_id' => 89,
                'role_id' => 1
            ],
            [
                'permission_id' => 89,
                'role_id' => 2
            ],
            [
                'permission_id' => 89,
                'role_id' => 3
            ],
            [
                'permission_id' => 89,
                'role_id' => 4
            ],
            [
                'permission_id' => 89,
                'role_id' => 5
            ],
            [
                'permission_id' => 89,
                'role_id' => 6
            ],
            [
                'permission_id' => 89,
                'role_id' => 7
            ],
            [
                'permission_id' => 89,
                'role_id' => 8
            ],
            [
                'permission_id' => 89,
                'role_id' => 9
            ],
            [
                'permission_id' => 89,
                'role_id' => 10
            ],
            [
                'permission_id' => 90,
                'role_id' => 1
            ],
            [
                'permission_id' => 90,
                'role_id' => 2
            ],
            [
                'permission_id' => 90,
                'role_id' => 3
            ],
            [
                'permission_id' => 90,
                'role_id' => 4
            ],
            [
                'permission_id' => 90,
                'role_id' => 5
            ],
            [
                'permission_id' => 90,
                'role_id' => 6
            ],
            [
                'permission_id' => 90,
                'role_id' => 7
            ],
            [
                'permission_id' => 90,
                'role_id' => 8
            ],
            [
                'permission_id' => 90,
                'role_id' => 9
            ],
            [
                'permission_id' => 90,
                'role_id' => 10
            ],
            [
                'permission_id' => 91,
                'role_id' => 1
            ],
            [
                'permission_id' => 91,
                'role_id' => 2
            ],
            [
                'permission_id' => 91,
                'role_id' => 3
            ],
            [
                'permission_id' => 91,
                'role_id' => 4
            ],
            [
                'permission_id' => 91,
                'role_id' => 5
            ],
            [
                'permission_id' => 91,
                'role_id' => 6
            ],
            [
                'permission_id' => 91,
                'role_id' => 7
            ],
            [
                'permission_id' => 91,
                'role_id' => 8
            ],
            [
                'permission_id' => 91,
                'role_id' => 9
            ],
            [
                'permission_id' => 91,
                'role_id' => 10
            ],
            /** Employees 92 to 96 (programmer, administrator, managers, financiers) */
            [
                'permission_id' => 92,
                'role_id' => 1
            ],
            [
                'permission_id' => 92,
                'role_id' => 2
            ],
            [
                'permission_id' => 92,
                'role_id' => 3
            ],
            [
                'permission_id' => 92,
                'role_id' => 5
            ],
            [
                'permission_id' => 93,
                'role_id' => 1
            ],
            [
                'permission_id' => 93,
                'role_id' => 2
            ],
            [
                'permission_id' => 93,
                'role_id' => 3
            ],
            [
                'permission_id' => 93,
                'role_id' => 5
            ],
            [
                'permission_id' => 94,
                'role_id' => 1
            ],
            [
                'permission_id' => 94,
                'role_id' => 2
            ],
            [
                'permission_id' => 94,
                'role_id' => 3
            ],
            [
                'permission_id' => 94,
                'role_id' => 5
            ],
            [
                'permission_id' => 95,
                'role_id' => 1
            ],
            [
                'permission_id' => 95,
                'role_id' => 2
            ],
            [
                'permission_id' => 95,
                'role_id' => 3
            ],
            [
                'permission_id' => 95,
                'role_id' => 5
            ],
            [
                'permission_id' => 96,
                'role_id' => 1
            ],
            [
                'permission_id' => 96,
                'role_id' => 2
            ],
            [
                'permission_id' => 96,
                'role_id' => 3
            ],
            [
                'permission_id' => 96,
                'role_id' => 5
            ],
            /** Ticket Payments 97 to 101 (programmer, administrator, managers, financiers) */
            [
                'permission_id' => 97,
                'role_id' => 1
            ],
            [
                'permission_id' => 97,
                'role_id' => 2
            ],
            [
                'permission_id' => 97,
                'role_id' => 3
            ],
            [
                'permission_id' => 97,
                'role_id' => 5
            ],
            [
                'permission_id' => 98,
                'role_id' => 1
            ],
            [
                'permission_id' => 98,
                'role_id' => 2
            ],
            [
                'permission_id' => 98,
                'role_id' => 3
            ],
            [
                'permission_id' => 98,
                'role_id' => 5
            ],
            [
                'permission_id' => 99,
                'role_id' => 1
            ],
            [
                'permission_id' => 99,
                'role_id' => 2
            ],
            [
                'permission_id' => 99,
                'role_id' => 3
            ],
            [
                'permission_id' => 99,
                'role_id' => 5
            ],
            [
                'permission_id' => 100,
                'role_id' => 1
            ],
            [
                'permission_id' => 100,
                'role_id' => 2
            ],
            [
                'permission_id' => 100,
                'role_id' => 3
            ],
            [
                'permission_id' => 100,
                'role_id' => 5
            ],
            [
                'permission_id' => 101,
                'role_id' => 1
            ],
            [
                'permission_id' => 101,
                'role_id' => 2
            ],
            [
                'permission_id' => 101,
                'role_id' => 3
            ],
            [
                'permission_id' => 101,
                'role_id' => 5
            ],
            /** Kanban 102 to 106 */
            [
                'permission_id' => 102,
                'role_id' => 1
            ],
            [
                'permission_id' => 102,
                'role_id' => 2
            ],
            [
                'permission_id' => 102,
                'role_id' => 3
            ],
            [
                'permission_id' => 102,
                'role_id' => 4
            ],
            [
                'permission_id' => 102,
                'role_id' => 7
            ],
            [
                'permission_id' => 102,
                'role_id' => 8
            ],
            [
                'permission_id' => 103,
                'role_id' => 1
            ],
            [
                'permission_id' => 103,
                'role_id' => 2
            ],
            [
                'permission_id' => 103,
                'role_id' => 3
            ],
            [
                'permission_id' => 103,
                'role_id' => 4
            ],
            [
                'permission_id' => 103,
                'role_id' => 7
            ],
            [
                'permission_id' => 103,
                'role_id' => 8
            ],
            [
                'permission_id' => 104,
                'role_id' => 1
            ],
            [
                'permission_id' => 104,
                'role_id' => 2
            ],
            [
                'permission_id' => 104,
                'role_id' => 3
            ],
            [
                'permission_id' => 104,
                'role_id' => 4
            ],
            [
                'permission_id' => 104,
                'role_id' => 7
            ],
            [
                'permission_id' => 104,
                'role_id' => 8
            ],
            [
                'permission_id' => 105,
                'role_id' => 1
            ],
            [
                'permission_id' => 105,
                'role_id' => 2
            ],
            [
                'permission_id' => 105,
                'role_id' => 3
            ],
            [
                'permission_id' => 105,
                'role_id' => 4
            ],
            [
                'permission_id' => 105,
                'role_id' => 7
            ],
            [
                'permission_id' => 105,
                'role_id' => 8
            ],
            [
                'permission_id' => 106,
                'role_id' => 1
            ],
            [
                'permission_id' => 106,
                'role_id' => 2
            ],
            [
                'permission_id' => 106,
                'role_id' => 3
            ],
            [
                'permission_id' => 106,
                'role_id' => 4
            ],
            [
                'permission_id' => 106,
                'role_id' => 7
            ],
            [
                'permission_id' => 106,
                'role_id' => 8
            ],
            /** Budgets 107 to ... */
            [
                'permission_id' => 107,
                'role_id' => 1
            ],
            [
                'permission_id' => 107,
                'role_id' => 2
            ],
            [
                'permission_id' => 107,
                'role_id' => 3
            ],
            [
                'permission_id' => 107,
                'role_id' => 4
            ],
            [
                'permission_id' => 107,
                'role_id' => 8
            ],
            [
                'permission_id' => 107,
                'role_id' => 9
            ],
            /** Work Items (Programmer and Administrator) */
            [
                'permission_id' => 108,
                'role_id' => 1
            ],
            [
                'permission_id' => 108,
                'role_id' => 2
            ],
            [
                'permission_id' => 109,
                'role_id' => 1
            ],
            [
                'permission_id' => 109,
                'role_id' => 2
            ],
            [
                'permission_id' => 110,
                'role_id' => 1
            ],
            [
                'permission_id' => 110,
                'role_id' => 2
            ],
            [
                'permission_id' => 111,
                'role_id' => 1
            ],
            [
                'permission_id' => 111,
                'role_id' => 2
            ],
        ]);
    }
}
