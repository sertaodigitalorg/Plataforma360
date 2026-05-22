# Data Warehouse Storage

Este diretório armazena os datasets consolidados e prontos para analytics.

## Estrutura

```
warehouse/
├── fact/          # Tabelas fato (fact_*)
├── dim/           # Tabelas dimensão (dim_*)
├── dw/            # Data Warehouse consolidado (dw_*)
└── exports/       # Exports gerados a partir do warehouse
```

## Schemas PostgreSQL

As tabelas analíticas são armazenadas no schema `warehouse` do PostgreSQL:

- `warehouse.dw_turismo_agencias` — Agências de turismo consolidadas
- `warehouse.fact_agencias_turismo` — Fatos analíticos de agências
- `warehouse.dim_municipios` — Dimensão municípios (IBGE)
- `warehouse.dim_estados` — Dimensão estados
- `warehouse.dim_periodo` — Dimensão temporal

## Fluxo

```
CKAN → RAW → STAGING → WAREHOUSE → METABASE → INDICADORES → APIs
```
