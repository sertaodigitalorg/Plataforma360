# Instalacao

## Pre-requisitos

- Docker
- Docker Compose v2
- Git
- Make ou WSL em Windows

## Passos

```bash
cp .env.example .env
make install
```

O comando constroi a imagem PHP, sobe Nginx, PHP-FPM, PostgreSQL/PostGIS e Adminer, e tenta executar as migrations Doctrine.

Para carregar os dados de demonstracao, incluindo o provedor CKAN inicial `Ministério do Turismo`, execute tambem:

```bash
cd apps/core
php bin/console doctrine:fixtures:load
```

## URLs

- Plataforma: http://localhost:8080
- API Platform: http://localhost:8080/api
- Healthcheck: http://localhost:8080/health
- Adminer: http://localhost:8081

## Navegacao do modulo CKAN

Depois de subir a aplicacao, o menu `Dados` passa a oferecer:

- `Provedores de Dados`
- `Pacotes CKAN`
- `Ingestão de Dados`
- `Histórico de Execuções`

O seed inicial ja cadastra o portal `https://dados.turismo.gov.br` com as rotas padrao de `package_list` e `package_show`.

## Banco

- Host: `postgres`
- Porta interna: `5432`
- Banco: `plataforma360`
- Usuario: `plataforma360`
- Senha: `plataforma360`

A extensao PostGIS e habilitada automaticamente pelos scripts em `infra/postgres/init`.