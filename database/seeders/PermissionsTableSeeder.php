<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('permissions')->insert([
            /** ACL  1 to 11 */
            [
                'name' => 'Acessar ACL',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Permissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Sincronizar Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Atribuir Perfis',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],

            /** Users 12 to 17 */
            [
                'name' => 'Acessar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** 15 (edit own profile) */
            [
                'name' => 'Editar Usuário',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Usuários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Activities 18 to 22 */
            [
                'name' => 'Acessar Atividades',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Atividades',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Atividades',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Atividades',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Atividades',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Activities 23 to 29 */
            [
                'name' => 'Acessar Filiais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Filiais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Filiais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Filiais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Filiais',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Acessar Colaboradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Colaboradores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Clients 30 to 34 */
            [
                'name' => 'Acessar Clientes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Clientes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Clientes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Clientes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Clientes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Service Orders 35 to 39 */
            [
                'name' => 'Acessar Ordens de Serviço',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Ordens de Serviço',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Ordens de Serviço',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Ordens de Serviço',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Ordens de Serviço',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** List Managers 40  */
            [
                'name' => 'Listar Gerentes',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
        ]);
    }
}
