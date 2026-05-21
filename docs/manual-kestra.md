# Manual do Kestra na Plataforma360

## O que e o Kestra no contexto da Plataforma360

O Kestra e a camada inicial de ingestao, automacao de pipelines e orquestracao de dados da Plataforma360. Ele permite que uma prefeitura agende, execute, monitore e versione fluxos de dados sem acoplar essas rotinas ao core do sistema Symfony.

## Papel do Kestra na arquitetura

Na arquitetura da Plataforma360, o Kestra opera como modulo separado da aplicacao principal. Seu papel e:

- receber dados de fontes municipais, arquivos, APIs e coletas futuras;
- padronizar fluxos de ingestao para a zona `raw`;
- preparar cargas para PostgreSQL/PostGIS;
- registrar execucoes, tentativas e historico operacional;
- manter a automacao fora do Core GovTech.

O Airflow nao e dependencia inicial. Ele permanece apenas como opcao futura avancada para municipios que precisarem de uma camada adicional de orquestracao complexa.

## Diferenca entre Kestra, Symfony, PostgreSQL e Superset

- `Kestra`: orquestra fluxos, automacoes, ingestao e jobs.
- `Symfony`: entrega a aplicacao institucional, APIs, telas administrativas e regras de negocio.
- `PostgreSQL/PostGIS`: persiste dados transacionais, geoespaciais e camadas `raw` e `processed`.
- `Superset` futuro: consome dados tratados para dashboards e analise visual.

## Como subir o Kestra no Docker

Ambiente recomendado no Windows: executar os comandos dentro do WSL Ubuntu, mantendo compatibilidade com Docker Desktop.

```bash
cd /mnt/c/Plataforma360
docker compose -f docker-compose.kestra.yml up -d
```

Ou, pelo atalho do projeto:

```bash
make kestra-up
```

Para parar o stack:

```bash
docker compose -f docker-compose.kestra.yml down
```

## Como acessar a interface web

A interface web do Kestra fica exposta em:

- http://localhost:8082/ui/

Ao acessar pela primeira vez em ambiente local, o redirecionamento HTTP para `/ui/` indica que o servico esta ativo.

## Como criar ou importar um fluxo

Existem duas abordagens recomendadas:

1. Versionar o fluxo em YAML dentro de `future/kestra/flows/`.
2. Importar o YAML pela interface web do Kestra ou por API quando a equipe operacional estiver pronta para executar.

Fluxo inicial versionado neste projeto:

- `future/kestra/flows/olinda360_primeira_ingestao.yml`

Arquivo de exemplo usado pelo fluxo:

- `future/kestra/examples/pontos_turisticos_olinda.csv`

## Como executar o primeiro fluxo de ingestao

Fluxo: `olinda360_primeira_ingestao`

Objetivo do fluxo:

- simular ingestao de dados turisticos de Olinda;
- preparar um CSV bruto para futura carga;
- gerar um script SQL base para a schema `raw`.

Passos operacionais:

1. Suba o stack do Kestra.
2. Abra http://localhost:8082/ui/.
3. Importe o arquivo `future/kestra/flows/olinda360_primeira_ingestao.yml` no namespace `plataforma360.turismo`.
4. Execute o fluxo pela UI.
5. Verifique nos logs do fluxo a preparacao dos artefatos e a contagem de registros.

## Como o Kestra se conecta futuramente ao PostgreSQL/PostGIS

No estado atual, o Kestra usa PostgreSQL proprio para metadados e fila interna, o que e a melhor pratica para ambiente local modular e seguro. Futuramente, os fluxos podem se conectar ao PostgreSQL/PostGIS principal da Plataforma360 para:

- gravar dados diretamente na schema `raw`;
- executar validacoes geoespaciais com PostGIS;
- promover dados para `processed` apos transformacoes;
- disparar jobs de publicacao para APIs e analytics.

Essa conexao pode ser feita por JDBC, plugins SQL do Kestra ou execucao de scripts controlados.

## Boas praticas para prefeituras instalarem localmente

- usar WSL Ubuntu no Windows para execucao dos comandos Docker e Make;
- manter `docker-compose.yml` e `docker-compose.kestra.yml` separados;
- armazenar fluxos em controle de versao;
- comecar por ingestoes simples e auditaveis;
- separar dados `raw` de dados prontos para consumo;
- evitar misturar regras de pipeline dentro do Core Symfony;
- registrar credenciais reais em variaveis locais e nunca em arquivos versionados.

## Comandos uteis de Docker

```bash
docker compose -f docker-compose.kestra.yml up -d
docker compose -f docker-compose.kestra.yml down
docker compose -f docker-compose.kestra.yml restart
docker compose -f docker-compose.kestra.yml ps
docker compose -f docker-compose.kestra.yml logs --tail=200
docker compose -f docker-compose.kestra.yml logs -f kestra
curl -I http://localhost:8082
```

Atalhos do projeto:

```bash
make kestra-up
make kestra-down
make kestra-logs
make kestra-restart
```

## Troubleshooting basico

`Porta 8082 em uso`

- ajuste `KESTRA_PORT` no ambiente local antes de subir o stack.

`Docker nao encontrado no Windows`

- execute os comandos via WSL Ubuntu, onde o Docker Compose esta disponivel neste ambiente.

`Kestra nao conecta no PostgreSQL`

- verifique `future/kestra/application.yml` e os logs com `docker compose -f docker-compose.kestra.yml logs -f kestra`.

`Interface nao abre`

- confirme com `docker compose -f docker-compose.kestra.yml ps` se a porta `8082->8080` esta publicada;
- teste `curl -I http://localhost:8082` e espere redirecionamento para `/ui/`.

`Preciso integrar com o banco principal`

- faca isso por fluxo versionado, mantendo o Kestra desacoplado do Core e documentando credenciais e destinos antes de operar em producao.