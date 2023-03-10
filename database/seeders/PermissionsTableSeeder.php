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
            /** Subsidiaries 23 to 29 */
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
            /** Providers 41 to 45*/
            [
                'name' => 'Acessar Fornecedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Fornecedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Fornecedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Fornecedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Fornecedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Finance 46*/
            [
                'name' => 'Acessar Financeiro',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Incomes 47 to 51*/
            [
                'name' => 'Acessar Rendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Rendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Rendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Rendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Rendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Expenses 52 to 56*/
            [
                'name' => 'Acessar Despesas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Despesas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Despesas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Despesas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Despesas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Refunds 57 to 61*/
            [
                'name' => 'Acessar Reembolsos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Reembolsos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Reembolsos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Reembolsos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Reembolsos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** List Managers 62  */
            [
                'name' => 'Listar Financiers',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Purchase Orders 63 to  67*/
            [
                'name' => 'Acessar Ordens de Compra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Ordens de Compra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Ordens de Compra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Ordens de Compra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Ordens de Compra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Products 68 to 72*/
            [
                'name' => 'Acessar Estoque',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Produtos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Produtos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Produtos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Produtos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Stocks 73 to 76 */
            [
                'name' => 'Listar Movimentações',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Movimentações',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Movimentações',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Movimentações',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Commissions 77 to 86 */
            [
                'name' => 'Acessar Comissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Comissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Comissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Comissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Comissões',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Vendedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Vendedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Vendedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Vendedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Acessar Vendedores',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Schedules 87 to 91*/
            [
                'name' => 'Acessar Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Eventos na Agenda',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Employees 92 to 96 */
            [
                'name' => 'Acessar Funcionários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Funcionários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Funcionários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Funcionários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Funcionários',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Ticket Payments 97 to 101 */
            [
                'name' => 'Acessar Pagamento de Passagens',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Pagamento de Passagens',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Pagamento de Passagens',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Pagamento de Passagens',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Pagamento de Passagens',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** Sales Funnel 102 to 106 */
            [
                'name' => 'Acessar Funil de Vendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Funil de Vendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Funil de Vendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Funil de Vendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Funil de Vendas',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            /** bBudgets 107 to ...*/
            [
                'name' => 'Acessar Orçamentos',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Listar Itens de Obra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Criar Itens de Obra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Editar Itens de Obra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],
            [
                'name' => 'Excluir Itens de Obra',
                'guard_name' => 'web',
                'created_at' => new DateTime('now')
            ],

        ]);
    }
}
