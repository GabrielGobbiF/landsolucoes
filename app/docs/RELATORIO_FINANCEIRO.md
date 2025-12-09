# Relatórios Financeiros - Sistema de Obras

## Descrição

Sistema completo de relatórios financeiros para obras, permitindo visualizar informações sobre valores a receber e a faturar, com filtros dinâmicos e interface moderna.

## Funcionalidades

### Tipos de Relatórios

1. **A Receber**
   - Lista todas as faturas pendentes de recebimento
   - Mostra valores vencidos e a vencer
   - Exibe próximas datas de vencimento
   - Permite agrupar por obra

2. **A Faturar**
   - Lista todas as etapas com valores pendentes de faturamento
   - Mostra valor total, faturado e saldo a faturar
   - Permite agrupar por obra

### Filtros Disponíveis

- **Tipo de Relatório**: A Receber ou A Faturar
- **Busca**: Por nome da obra ou número de NFE
- **Obra**: Filtro específico por obra (com busca dinâmica)
- **Agrupar por Obra**: Agrupa os resultados por obra
- **Itens por página**: 15, 25, 50 ou 100 registros

### Cards de Totais

Os cards no topo da página mostram:

**Para A Receber:**
- Total a Receber (em R$)
- Total Vencidas (em R$)
- Quantidade de faturas/obras

**Para A Faturar:**
- Total a Faturar (em R$)
- Quantidade de etapas/obras

### Tabelas Dinâmicas

As tabelas se adaptam conforme o tipo de relatório e se está agrupado ou não:

**A Receber (Detalhado):**
- Obra
- NFE
- Cliente
- Etapa
- Valor
- Vencimento
- Status (Vencido, Vence em breve, A vencer)

**A Receber (Agrupado):**
- Obra
- NFE
- Cliente
- Total a Receber
- Vencidas
- Próximo Vencimento
- Qtd Etapas

**A Faturar (Detalhado):**
- Obra
- NFE
- Cliente
- Etapa
- Valor Total
- Faturado
- A Faturar
- Status

**A Faturar (Agrupado):**
- Obra
- NFE
- Cliente
- Total a Faturar
- Qtd Etapas

## Arquivos Criados

### Backend

1. **Controller**: `app/Http/Controllers/Painel/Relatorios/RelatorioFinanceiroController.php`
   - Métodos principais:
     - `index()`: Renderiza a view
     - `getData()`: Retorna dados via AJAX
     - `getObras()`: Busca obras para o filtro
     - `getEtapas()`: Busca etapas para o filtro

2. **Resource**: `app/Http/Resources/RelatorioFinanceiroResource.php`
   - Formata os dados de faturamento para a API

3. **Model**: Atualizado `app/Models/EtapasFaturamento.php`
   - Adicionado relacionamento com `ObraEtapasFinanceiro`

### Frontend

1. **View**: `resources/views/pages/relatorios/financeiro/index.blade.php`
   - Interface completa com filtros
   - Cards de totais
   - Tabela dinâmica
   - Paginação

### Rotas

Adicionadas em `routes/web.php`:
```php
Route::get('relatorios/financeiro', [RelatorioFinanceiroController::class, 'index'])
    ->name('relatorios.financeiro.index');
Route::get('relatorios/financeiro/data', [RelatorioFinanceiroController::class, 'getData'])
    ->name('relatorios.financeiro.data');
Route::get('relatorios/financeiro/obras', [RelatorioFinanceiroController::class, 'getObras'])
    ->name('relatorios.financeiro.obras');
Route::get('relatorios/financeiro/etapas', [RelatorioFinanceiroController::class, 'getEtapas'])
    ->name('relatorios.financeiro.etapas');
```

## Como Acessar

Acesse a URL: `/relatorios/financeiro`

Ou adicione um link no menu do sistema:
```html
<a href="{{ route('relatorios.financeiro.index') }}">Relatórios Financeiros</a>
```

## Tecnologias Utilizadas

- **Backend**: Laravel (PHP)
- **Frontend**: Blade, jQuery, Axios
- **UI**: Bootstrap 4/5
- **Ícones**: Remix Icons
- **Componentes**: Select2 para busca de obras

## Observações

- O sistema utiliza paginação do Laravel para melhor performance
- Os dados são carregados via AJAX para uma experiência mais fluida
- Os filtros são aplicados dinamicamente sem recarregar a página
- As cores dos status são automáticas (vencido = vermelho, a vencer = verde, etc.)
- Links para as obras são clicáveis na tabela

## Próximas Melhorias Sugeridas

1. Exportação para Excel/PDF
2. Gráficos de visualização
3. Filtros por data
4. Filtros por cliente
5. Ordenação por colunas
6. Histórico de recebimentos
7. Notificações de vencimento
