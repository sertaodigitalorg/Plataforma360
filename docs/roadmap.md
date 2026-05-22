# Roadmap

## Fase 1 - Core Instalavel

- Docker Compose com Nginx, PHP 8.3 FPM, PostgreSQL/PostGIS e Adminer.
- Symfony 7 com Doctrine, Twig, Bootstrap 5 e API Platform.
- Homepage institucional, healthcheck e OpenAPI.

## Fase 2 - Dados Territoriais

- Modelo territorial base.
- Ingestao de dados abertos.
- Organizacao das zonas raw, staging e processed.
- APIs publicas versionadas.
- Modulo CKAN no Core para cadastro de provedores, sincronizacao de `package_list`, consulta de `package_show` e selecao de pacotes monitorados.

## Fase 3 - Analytics e Observabilidade

- Dashboards territoriais.
- Indicadores turisticos.
- Logs estruturados, metricas e traces.
- Grafana e Superset.
- Evolucao da camada CKAN para verificacao diaria, download automatizado de resources e disparo de pipelines Kestra.

## Fase 4 - Interoperabilidade e IA

- MCP Layer.
- AI Hub.
- Vector DB.
- Conectores com sistemas publicos.