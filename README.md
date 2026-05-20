# Plataforma360

Plataforma360 e a base open source instalavel do projeto Olinda360: uma GovTech para inteligencia territorial, turismo inteligente, APIs publicas, analytics, dados abertos e interoperabilidade municipal.

A plataforma nao e SaaS. O objetivo e permitir que prefeituras, laboratorios de inovacao e equipes tecnicas instalem o ambiente localmente ou em VPS propria, mantendo autonomia sobre dados, infraestrutura e evolucao.

## Arquitetura

- `apps/core`: aplicacao Symfony 7 com API Platform, Doctrine ORM, Twig e Bootstrap 5.
- `infra/nginx`: proxy HTTP e front controller da aplicacao.
- `infra/php`: imagem PHP 8.3 FPM com extensoes para PostgreSQL/PostGIS.
- `infra/postgres`: scripts de inicializacao do PostgreSQL 16 com PostGIS.
- `data`: zonas raw, staging e processed para pipelines de dados.
- `future`: espaco reservado para data platform, Airflow, Airbyte, Superset, Grafana, AI Hub, MCP e vector database.

## Requisitos

- Git
- Docker
- Docker Compose v2
- Make, em Linux/macOS ou WSL

## Instalacao

```bash
git clone <repo-url> Plataforma360
cd Plataforma360
cp .env.example .env
make install
```

Apos subir o ambiente:

- Aplicacao: http://localhost:8080
- OpenAPI/Swagger: http://localhost:8080/api
- Healthcheck: http://localhost:8080/health
- Adminer: http://localhost:8081

Credenciais padrao do banco:

- Servidor: `postgres`
- Banco: `plataforma360`
- Usuario: `plataforma360`
- Senha: `plataforma360`

## Comandos Docker

```bash
make up       # sobe os containers
make down     # para os containers
make restart  # reinicia os containers
make logs     # acompanha logs
make bash     # shell no container PHP
make migrate  # executa migrations Doctrine
```

## Estrutura

```text
Plataforma360/
├── apps/core/
├── infra/
├── docs/
├── scripts/
├── data/
├── future/
├── docker-compose.yml
├── .env.example
├── Makefile
└── README.md
```

## Roadmap Inicial

1. Consolidar modelo territorial e catalogo de dados publicos.
2. Evoluir APIs publicas versionadas e documentadas por OpenAPI.
3. Adicionar dashboards territoriais e turisticos.
4. Integrar observabilidade com logs, metricas e traces.
5. Preparar camada MCP e IA para consulta contextual aos dados municipais.
6. Implantar conectores de interoperabilidade com sistemas publicos.

## Licenca

Distribuicao prevista como projeto open source para instalacao local por municipios e comunidades tecnicas.