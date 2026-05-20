# Arquitetura da Plataforma360

A Plataforma360 adota uma arquitetura modular orientada a instalacao local, soberania de dados e interoperabilidade publica.

## Camadas

- Interface institucional: Twig, Bootstrap 5 e rotas Symfony.
- API publica: API Platform, REST, OpenAPI e recursos versionaveis.
- Dominio: entidades Doctrine e servicos de aplicacao no `apps/core/src`.
- Persistencia: PostgreSQL 16 com extensao PostGIS.
- Infraestrutura: Docker Compose, Nginx, PHP 8.3 FPM e Adminer.
- Dados: zonas `raw`, `staging` e `processed` para evolucao da data platform.

## Principios

- Nao SaaS: cada prefeitura pode instalar e operar seu ambiente.
- Open source: estrutura preparada para GitHub e contribuicoes.
- Clean architecture pragmatica: dominio separado de infraestrutura sempre que a complexidade justificar.
- Interoperabilidade: APIs documentadas e contratos publicos evolutivos.
- Observabilidade: healthcheck e base pronta para metricas, logs e traces.

## Evolucao Planejada

A pasta `future` reserva os modulos de plataforma de dados, orquestracao, BI, observabilidade, IA, MCP e banco vetorial.