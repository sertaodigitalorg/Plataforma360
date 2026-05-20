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

## URLs

- Plataforma: http://localhost:8080
- API Platform: http://localhost:8080/api
- Healthcheck: http://localhost:8080/health
- Adminer: http://localhost:8081

## Banco

- Host: `postgres`
- Porta interna: `5432`
- Banco: `plataforma360`
- Usuario: `plataforma360`
- Senha: `plataforma360`

A extensao PostGIS e habilitada automaticamente pelos scripts em `infra/postgres/init`.