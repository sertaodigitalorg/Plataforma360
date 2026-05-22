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

No Windows, prefira executar as rotinas via WSL apontando para `/mnt/c/Plataforma360`, por exemplo:

```bash
cd /mnt/c/Plataforma360
docker compose up -d --build
```

Para carregar os dados de demonstracao, incluindo o provedor CKAN inicial `Ministério do Turismo`, execute tambem:

```bash
docker compose exec -T php php bin/console doctrine:fixtures:load
```

Para aplicar a Fase 2 da pipeline operacional, execute tambem as migrations novas:

```bash
docker compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction
```

As bibliotecas de preview exigem as extensoes PHP `gd`, `mbstring`, `dom`, `xml`, `xmlreader`, `xmlwriter` e `simplexml`, ja previstas no Dockerfile do projeto.

## URLs

- Plataforma: http://localhost:8080
- API Platform: http://localhost:8080/api
- Healthcheck: http://localhost:8080/health
- Adminer: http://localhost:8081

## Navegacao do modulo CKAN

Depois de subir a aplicacao, o menu `Dados` passa a oferecer:

- `Visão Geral`
- `Provedores de Dados`
- `Pacotes CKAN`
- `Ingestão de Dados`
- `Arquivos RAW`
- `Preview Dataset`
- `Histórico de Execuções`

O seed inicial ja cadastra o portal `https://dados.turismo.gov.br` com as rotas padrao de `package_list` e `package_show`.

Os usuarios padrao para homologacao local continuam sendo:

- `jane_admin / kitten`
- `john_user / kitten`

As telas da pipeline CKAN estao restritas a `ROLE_ADMIN`.

## Storage RAW

Os arquivos fisicos passam a ser gravados em:

```text
storage/raw/{provider_slug}/{package_slug}/{year}/{month}/
```

No Docker, esse diretorio e montado como `/var/storage/raw` dentro do container PHP.

Para validar que o download ocorreu fisicamente, use:

```bash
find storage/raw -type f | head
```

Ou liste um pacote especifico:

```bash
find storage/raw/ministerio-turismo -type f
```

Depois do download, a tela `Dados -> Arquivos RAW` mostra o path, hash SHA256, status e links para preview/metadata.

## Fluxo de validacao da pipeline

1. Acesse `Dados -> Pacotes CKAN` com `jane_admin`.
2. Clique em `Executar pipeline` ou `Baixar resource` em um pacote sincronizado.
3. Verifique o arquivo em `Dados -> Arquivos RAW`.
4. Abra `Dados -> Preview Dataset` para CSV/XLSX.
5. Consulte `Dados -> Histórico de Execuções` para eventos como `download_concluido`, `parser_concluido` e `schema_detectado`.

## Banco

- Host: `postgres`
- Porta interna: `5432`
- Banco: `plataforma360`
- Usuario: `plataforma360`
- Senha: `plataforma360`

A extensao PostGIS e habilitada automaticamente pelos scripts em `infra/postgres/init`.