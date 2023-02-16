# Service Order Generator

<h5>Pending Tasks</h5>
<ol>
    <li>Apresentar o vendedor do cliente no "Funil de Vendas";</li>
    <li>Implementar filtro de Vendedores no "Funil de Vendas";</li>
    <li>Implementar importação por planilha no "Funil de Vendas";</li>
    <li>Apresentar o número de cartões em cada coluna no "Funil de Vendas";</li>
    <li>Apresentar na OS o endereço do cliente selecionado;</li>
    <li>Criar página específica para as OS do dia ou não concluídas para facilitar a elaboração do roteiro;</li>
    <li>Módulo de compartilhamento de documentos padronizados entre gerentes;</li>   
    <li>Módulo de orçamento;</li>
    <li>DCI;</li>
    <li>Módulo de medição digital;</li>
    <li>Replicar módulo de clientes no módulo de medição digital;</li>    
    <li>Criação de OS exclusiva para medição por condomínio com status de: Não lido, Lido, Aguardando conta/digitado, Conferido, Enviado, Problema;</li>
    <li>Quando selecionado o problema, abrir campo "observação";</li>
    <li>Criar nova OS a partir de uma alteração de status de OS para "enviado" abrindo um campo para inserção de nova data;</li>
    <li>Importação de OS por planilha;</li>
    <li>Colocar papel timbrado;</li>
    <li>Criar OS dos seguintes serviços:
        <ul>
            <li>Troca de medidor;</li>
            <li>Visita Orçamentária de individualização de água;</li>
            <li>Visita Orçamentária de gás;</li>
            <li>Visita Orçamentária de bloqueador de ar;</li>
            <li>Visita Orçamentária de manutenção de bomba;</li>
            <li>Visita Orçamentária de medidor de nível;</li>
            <li>Visita Orçamentária de "previsto água"; e</li>
            <li>Requisição de Material <b>no módulo de estoque</b></li>
        </ul>
    </li>
    <li>Na OS "troca de medidor" inserir os seguintes campos:
        <ul>
            <li>leitura medidor antigo;</li>
            <li>leitura medidor novo;</li>
            <li>chassi medidor novo; e</li>
            <li>número de lacre medidor novo</li>
        </ul>
    </li>
    <li>Quando houver um OS com a atividade "troca de medidor" e ela estiver concluída enviar e-mail para medicao@acquaxdobrasil.com.br;</li>
    <li>Colocar o disparo de SMS e WhatsApp para ordem de compra;</li>    
    <li>Integração de notificação com 3CX;</li>
    <li>Avaliação do serviço prestado pelos colaboradores (enviar e-mail ao cliente com link de avaliação);</li>
    <li>Atividade de Colaborador na relação a Ordem de serviço (indíces cruzados com avaliação);</li>
    <li>Relarório de métrica colaborador por atividade (esse é um ponto mais complexo, que envolverá um cruzamento de dados, mas realizável);</li>
    <li>Envio da ordem de serviço automática para o cliente;</li>    
    <li>Assinatura digital;</li>
    <li>Módulo de pagamentos com PIX dos funcionários;</li>
    <li>Comunicação via whats e mensagem;</li>
    <li>Colocar contrato e incluir novo estado para cliente e cadastrar contrato;</li>     
    <li>Módulo de Central de atendimentos;</li>
    <li>Colocar anexação de comprovantes no pagamento de passagens;</li>   
    <li>Colocar módulo de cálculo de quilometro rodado e custo médio mensal refente a quilometragem dos veículos utilizados para serviço pelos colaboradores. Fórmula de cálculo: (km<sub>final</sub> - km<sub>inicial</sub>) / 30 * valor<sub>combustível</sub> + pedágio;</li>
    <li>Remover campos obrigatórios na ordem de compra;</li>
    <li>Apresentar informações de log dos manipuladores da OS (visualização e edição); e</li>
    <li>Capturar localização do dispositivo no momento da manipulação da OS ou forçar o executar a inserir uma foto do local como obrigatória para editar a OS ou inserir fotos antes e depois da execução do serviço como prova de que a OS foi manipulada no local da sua execução; e</li>
    <li>Colocar campo de vendedor nas receitas.</li>
</ol>

<p>Useful commands</p>
<ul>
    <li>php artisan queue:work --once --quiet</li>
    <li>php artisan queue:work --stop-when-empty</li>
    <li>php artisan cache:clear</li>
</ul>
