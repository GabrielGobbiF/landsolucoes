# Comando: Atualizar Valores Financeiros das Obras

## Descrição
Este comando atualiza os valores de `valor_locacao` e `valor_compras_materiais` de todas as obras no sistema.

## Como usar

### Atualizar todas as obras
```bash
php artisan obras:atualizar-financeiro
```

### Atualizar uma obra específica
```bash
php artisan obras:atualizar-financeiro --obra-id=123
```

## Características

- ✅ Processa obras em chunks de 50 para otimizar memória
- ✅ Barra de progresso visual
- ✅ Contador de obras processadas e erros
- ✅ Logs de erros detalhados
- ✅ Opção de processar obra individual
- ✅ Ignora obras sem financeiro ou deletadas

## O que o comando faz

1. Busca todas as obras com financeiro ativo
2. Para cada obra:
   - Calcula valor de locação (etapas 235, 476, 542)
   - Calcula valor de compras de materiais (etapas 18, 377, 834)
   - Atualiza o registro em `obras_financeiro`
3. Exibe relatório final com sucessos e erros

## Exemplo de saída

```
Iniciando atualização de valores financeiros das obras...
Total de obras a processar: 150
 150/150 [============================] 100%

Processamento concluído!
Obras processadas com sucesso: 148
Obras com erro: 2
```

## Quando executar

- Após a migration inicial
- Quando houver mudanças nas etapas financeiras
- Para corrigir inconsistências nos dados
- Em manutenções programadas
