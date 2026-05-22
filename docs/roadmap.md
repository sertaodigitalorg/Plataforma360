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

## Fase 4 - Interoperabilidade e IA

- MCP Layer.
- AI Hub.
- Vector DB.
- Conectores com sistemas publicos.