# Roadmap

## Fase 1 - Core Instalavel

- Docker Compose com Nginx, PHP 8.3 FPM, PostgreSQL/PostGIS e Adminer.
- Symfony 7 com Doctrine, Twig, Bootstrap 5 e API Platform.
- Homepage institucional, healthcheck e OpenAPI.

## Fase 2 - Dados Territoriais e Pipeline Operacional

- Modelo territorial base.
- Ingestao de dados abertos via modulo CKAN no Core.
- Download fisico de resources para `storage/raw`.
- Registro de metadata operacional em `raw_files`.
- Preview real de datasets CSV/XLSX.
- Descoberta automatica de schema em `dataset_schemas`.
- Organizacao das zonas raw, staging e processed.
- APIs publicas versionadas.
- Modulo CKAN no Core para cadastro de provedores, sincronizacao de `package_list`, consulta de `package_show`, selecao de pacotes monitorados e execucao sincrona da pipeline `download -> raw -> preview -> schema`.

## Fase 3 - Analytics e Observabilidade

- Dashboards territoriais.
- Indicadores turisticos.
- Logs estruturados, metricas e traces.
- Grafana e Superset.
- Evolucao da camada CKAN para verificacao diaria, jobs assincronos e disparo de pipelines Kestra ou Messenger sobre a base operacional ja existente.

## Fase 4 - Data Warehouse, Analytics e Metabase ✅ Implementada

- Camada `warehouse.*` no PostgreSQL com schemas fact/dim/dw.
- Entidade `AnalyticModel` para definir transformações STAGING → WAREHOUSE.
- Serviço `WarehouseTransformationService` — orquestração de transformações analíticas.
- Serviço `MetabaseService` — integração com Metabase (teste de conexão, sync).
- `MetabaseConfig` — configuração de instância Metabase com status de conexão.
- `MetabaseDashboard` — registro e embed de dashboards Metabase.
- `AnalyticsHistory` — trilha de auditoria de todos os eventos analíticos.
- APIs analíticas: `/api/analytics/indicadores`, `/turismo/agencias`, `/ranking`, `/lineage`.
- Linhagem de dados (CKAN → RAW → STAGING → WAREHOUSE → DASHBOARDS).
- Embed responsivo de dashboards via iframe integrado ao visual da plataforma.
- Menu atualizado: Dados → Warehouse/Modelos/Linhagem, Inteligência → Dashboards BI, Integrações → Metabase/APIs Analíticas.
- Manual do usuário em `docs/manual-usuario.md`.

## Fase 5 - Interoperabilidade e IA (Futuro)

- MCP Layer.
- AI Hub.
- Vector DB.
- Conectores com sistemas públicos.
- Automação Kestra avançada.