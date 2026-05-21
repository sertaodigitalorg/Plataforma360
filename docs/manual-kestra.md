# Manual do Kestra na Plataforma360

## O que e o Kestra no contexto da Plataforma360

O Kestra e a camada de ingestao, automacao de pipelines e orquestracao de dados da Plataforma360. Ele permite que uma prefeitura agende, execute, monitore e versione fluxos de dados sem acoplar essas rotinas ao portal central em Symfony.

## Papel do Kestra na arquitetura

Na arquitetura da Plataforma360, o Kestra opera como modulo separado da aplicacao principal. Seu papel e:

- receber dados de fontes municipais, arquivos, APIs e coletas futuras;
- armazenar dados brutos no MinIO como etapa inicial de data lake;
- transformar e preparar cargas para PostgreSQL;
- registrar execucoes, tentativas e historico operacional;
- integrar APIs, bancos, arquivos e servicos externos;
- manter a automacao tecnica fora do portal central de governanca.

O Airflow nao e dependencia inicial. Ele permanece apenas como opcao futura avancada para municipios que precisarem de uma camada adicional de orquestracao complexa.

## Limites de responsabilidade do Kestra

O Kestra deve ser usado para fluxos tecnicos de dados e automacao da data platform. Ele nao deve assumir papeis de:

- interface de usuario final;
- dashboards executivos;
- atendimento digital via chatbot;
- automacoes conversacionais;
- observabilidade tecnica central.

## Diferenca entre Kestra e os demais componentes

- `Kestra`: orquestra fluxos, automacoes, ingestao e jobs.
- `Symfony`: entrega o portal central de governanca, APIs, telas administrativas, permissoes e configuracoes do ecossistema.
- `MinIO`: armazena arquivos brutos, historico de ingestoes e objetos da camada de dados.
- `PostgreSQL`: persiste dados relacionais, metadados, configuracoes e dados estruturados tratados.
- `Metabase`: consome dados tratados para dashboards, indicadores e analytics de negocio.
- `Grafana`: monitora logs, metricas, alertas e saude tecnica da infraestrutura.
- `n8n`: opera webhooks, automacoes operacionais, IA e integracoes conversacionais no AI Hub.

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
- preparar um CSV bruto para armazenamento inicial;
- gerar uma base de transformacao para posterior carga estruturada.

Passos operacionais:

1. Suba o stack do Kestra.
2. Abra http://localhost:8082/ui/.
3. Importe o arquivo `future/kestra/flows/olinda360_primeira_ingestao.yml` no namespace `plataforma360.turismo`.
4. Execute o fluxo pela UI.
5. Verifique nos logs do fluxo a preparacao dos artefatos, a contagem de registros e os passos de transformacao.

## Como o Kestra se conecta ao MinIO e ao PostgreSQL

No estado atual, o Kestra usa PostgreSQL proprio para metadados e fila interna, o que e a melhor pratica para ambiente local modular e seguro. Na arquitetura oficial da Plataforma360, os fluxos devem usar:

- `MinIO` para receber e preservar arquivos brutos;
- `PostgreSQL` para gravar dados estruturados, tratados e prontos para consumo;
- `Metabase` como camada de leitura analitica sobre dados tratados;
- `Symfony` como portal central para acionamento e visao resumida do ecossistema.

Em evolucoes futuras, os fluxos podem se conectar ao PostgreSQL principal da Plataforma360 para:

- validar, limpar e estruturar dados recebidos do MinIO;
- executar validacoes geoespaciais com PostGIS, quando aplicavel;
- promover dados tratados para consumo institucional e analitico;
- disparar jobs de publicacao para APIs e analytics.

Essa conexao pode ser feita por JDBC, plugins SQL do Kestra ou execucao de scripts controlados.

## Boas praticas para prefeituras instalarem localmente

- usar WSL Ubuntu no Windows para execucao dos comandos Docker e Make;
- manter `docker-compose.yml` e `docker-compose.kestra.yml` separados;
- armazenar fluxos em controle de versao;
- comecar por ingestoes simples e auditaveis;
- separar dados brutos em MinIO de dados prontos para consumo em PostgreSQL;
- evitar misturar regras de pipeline dentro do Core Symfony;
- nao duplicar dashboards analiticos no portal central;
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

- faca isso por fluxo versionado, mantendo o Kestra desacoplado do portal Symfony e documentando credenciais, buckets e destinos antes de operar em producao.