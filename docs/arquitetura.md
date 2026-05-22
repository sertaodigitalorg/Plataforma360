# Arquitetura da Plataforma360

A Plataforma360 adota uma arquitetura modular orientada a instalacao local, soberania de dados, interoperabilidade publica e evolucao incremental. A plataforma foi desenhada para combinar aplicacao institucional, plataforma de dados, BI, observabilidade tecnica, automacao operacional e trilhas futuras de IA e IoT sem sobrepor responsabilidades.

O objetivo dessa arquitetura e permitir que cada componente execute bem uma funcao especifica: o portal central governa o ecossistema, a camada de dados processa e entrega informacao, as ferramentas analiticas exibem inteligencia de negocio, a observabilidade acompanha a saude tecnica, e os hubs especializados tratam automacao operacional, IA e telemetria.

## 1. Visao Geral da Plataforma 360

A Plataforma360 e uma plataforma publica modular orientada a dados, automacao, IA, BI, observabilidade e governanca. O desenho prioriza desacoplamento entre aplicacao principal e servicos especializados, reduzindo dependencia entre camadas e facilitando implantacao local por municipio, secretaria ou consorcio.

Como principios de base, a plataforma preserva instalacao local, soberania de dados, interoperabilidade publica, abordagem open source, APIs documentadas, contratos evolutivos e clean architecture pragmatica sempre que a separacao entre dominio e infraestrutura agregar valor real.

Os blocos arquiteturais sao organizados da seguinte forma:

```text
Plataforma360
├── Portal Central de Governanca
│   └── Symfony
├── Data Platform
│   └── Kestra + PostgreSQL + MinIO
├── BI e Analytics
│   └── Metabase
├── Observabilidade Tecnica
│   └── Grafana
├── AI Hub
│   └── n8n
├── IoT Hub
│   └── Sensores + MQTT + Telemetria
├── Apps
│   └── Modulos de negocio e servicos digitais
└── Shared
    └── Autenticacao, contratos, seguranca e padroes comuns
```

Em termos praticos, o Core em `apps/core` permanece como portal central de governanca e configuracao, enquanto os demais componentes evoluem como servicos complementares e especializados. A pasta `future` continua reservada para trilhas de evolucao da data platform, observabilidade, AI Hub, IoT Hub e demais modulos avancados.

## 2. Principio de Separacao de Responsabilidades

A arquitetura da Plataforma360 adota separacao explicita de responsabilidades para evitar sobreposicao funcional, acoplamento indevido e retrabalho operacional.

- Symfony nao substitui BI.
- Metabase nao substitui aplicacao.
- Grafana nao substitui BI.
- Kestra nao substitui n8n.
- n8n nao substitui Data Platform.
- Cada componente tem papel especifico, fronteira clara e responsabilidade propria.

Na pratica, isso significa que a plataforma deve evitar concentrar dashboards analiticos, pipelines, observabilidade, automacoes operacionais e gestao institucional dentro de um unico sistema. O valor da arquitetura esta exatamente na especializacao de cada peca.

## 3. Responsabilidades por Componente

### 3.1 Symfony - Portal Central de Governanca

Responsavel por:

- Gestao de usuarios e permissoes.
- Cadastro de municipios, secretarias e orgaos.
- Cadastro de fontes de dados.
- Cadastro de integracoes.
- Catalogo de indicadores oficiais.
- Gestao de modulos da plataforma.
- Centralizacao de links e embeds dos dashboards.
- Acionamento de fluxos do Kestra.
- Exibicao de cards executivos e status resumidos.
- Administracao das configuracoes do ecossistema.
- Catalogo de provedores CKAN, pacotes sincronizados e monitoramento manual inicial.
- Consulta administrativa de metadados `package_list` e `package_show`.
- Registro institucional das execucoes de sincronizacao e da trilha de ingestao.

Nao deve ser responsavel por:

- Construir dashboards analiticos complexos.
- Substituir Metabase ou outra ferramenta de BI.
- Armazenar grandes volumes de dados brutos.
- Executar pipelines pesados de dados.

### 3.1.1 Modulo CKAN de Provedores de Dados

Dentro do Core Symfony, a Plataforma360 passou a contar com um modulo administrativo para provedores de dados CKAN. Esse modulo vive no menu `Dados` e organiza a camada de ingestao publica em quatro superficies:

- `Provedores de Dados`: cadastro da fonte CKAN, base URL, rotas de `package_list` e `package_show`, status e sincronizacao manual;
- `Pacotes CKAN`: inventario persistido de pacotes retornados pela API, com ativacao de monitoramento por pacote;
- `Ingestao de Dados`: visao operacional preparada para futura automacao diaria, storage RAW e acionamento do Kestra;
- `Historico de Execucoes`: trilha de auditoria das sincronizacoes e verificacoes ja realizadas.

O dominio persistente foi estruturado em quatro tabelas principais:

- `data_providers`: cadastro de provedores CKAN;
- `provider_packages`: pacotes sincronizados de cada provedor;
- `dataset_resources`: resources retornados por `package_show`;
- `ingestion_runs`: historico de execucao, mensagens e logs estruturados.

Essa camada prepara o Core para orquestrar ingestao publica sem acoplar download pesado e pipeline completa ao portal institucional.

### 3.2 Kestra - Orquestracao de Dados

Responsavel por:

- Ingestao de dados.
- ETL e ELT.
- Agendamento de pipelines.
- Reprocessamento de fluxos.
- Automacao tecnica da Data Platform.
- Execucao de jobs.
- Registro de execucoes.
- Integracao com APIs, bancos, arquivos e servicos externos.

Nao deve ser responsavel por:

- Interface de usuario final.
- Dashboards executivos.
- Atendimento via chatbot.
- Automacoes conversacionais.

### 3.3 Metabase - BI e Analytics de Negocio

Responsavel por:

- Dashboards customizados.
- Indicadores de gestao publica.
- Relatorios analiticos.
- Graficos por secretaria.
- Series historicas.
- Comparativos entre municipios.
- Visualizacoes para prefeito, secretario, gestor e tecnico.
- Exportacao de relatorios.

Nao deve ser responsavel por:

- Gestao de usuarios da plataforma principal.
- Orquestracao de pipelines.
- Logs tecnicos de infraestrutura.
- Cadastro estrutural do ecossistema.

### 3.4 Grafana - Observabilidade Tecnica

Responsavel por:

- Metricas tecnicas.
- Logs de servicos.
- Saude dos containers.
- Uptime.
- CPU, memoria e disco.
- Monitoramento de APIs.
- Monitoramento de banco de dados.
- Alertas tecnicos.
- Monitoramento de Kestra, n8n e servicos internos.
- Futuro monitoramento IoT.

Nao deve ser responsavel por:

- Dashboards de negocio.
- Indicadores de politicas publicas.
- Cadastros administrativos.
- Operacao de fluxos de dados.

### 3.5 PostgreSQL - Banco Relacional

Responsavel por:

- Dados relacionais da aplicacao.
- Metadados da plataforma.
- Configuracoes.
- Usuarios, permissoes e cadastros.
- Dados estruturados tratados.

O PostgreSQL e o banco relacional principal da Plataforma360 e tambem o repositorio central de metadados. Quando necessario, pode sustentar extensoes e modelos voltados a dados geograficos e analiticos, sem assumir o papel de data lake.

### 3.6 MinIO - Data Lake e Armazenamento de Objetos

Responsavel por:

- Arquivos brutos.
- CSV, JSON, XML, PDFs e documentos.
- Dados recebidos antes do tratamento.
- Historico de ingestoes.
- Armazenamento compativel com S3.
- Base para pipelines de dados.

O MinIO funciona como camada de armazenamento de objetos e data lake inicial, desacoplando o recebimento de arquivos da persistencia relacional da aplicacao.

### 3.7 n8n - AI Hub e Automacoes Operacionais

Responsavel por:

- Webhooks.
- Integracoes rapidas.
- Fluxos com WhatsApp, e-mail, formularios e APIs.
- Chatbots.
- Automacoes com IA.
- Atendimento digital.
- Encaminhamento de demandas.
- Conexao entre sistemas externos e canais digitais.

Nao deve ser responsavel por:

- Data Lake.
- Pipelines analiticos pesados.
- BI principal.
- Observabilidade tecnica central.

### 3.8 IoT Hub - Sensores e Cidades Inteligentes

Responsavel por:

- Recebimento de dados de sensores.
- MQTT.
- Telemetria.
- Eventos de dispositivos.
- Regras de alerta.
- Integracao com dados urbanos.
- Futuras aplicacoes de cidade inteligente.

O IoT Hub permanece reservado para a evolucao da arquitetura em cenarios com sensores, dispositivos conectados e telemetria urbana em tempo real.

### 3.9 Apps - Aplicacoes da Plataforma

Responsavel por:

- Portal institucional.
- Painel administrativo.
- APIs.
- Servicos digitais.
- Modulos especificos por secretaria ou area de governo.

Apps representam os modulos de negocio da Plataforma360. Eles materializam funcionalidades para usuarios finais e equipes gestoras, utilizando servicos compartilhados e integracoes controladas com os demais componentes.

### 3.10 Shared - Camada Transversal

Responsavel por:

- Autenticacao.
- Autorizacao.
- Contratos de integracao.
- DTOs.
- Schemas.
- Padroes comuns.
- Seguranca.
- Observabilidade compartilhada.
- Bibliotecas internas.

Shared e a camada transversal que define consistencia tecnica entre modulos, reduz duplicacao de implementacao e padroniza contratos internos e externos.

## 4. Matriz de Responsabilidades

| Componente | Responsabilidade Principal | O que pode fazer | O que nao deve fazer |
| --- | --- | --- | --- |
| Symfony | Governanca e configuracao central | Usuarios, permissoes, cadastros, catalogos, modulos, links de dashboards, acionamento do Kestra e cards executivos | BI complexo, data lake, pipelines pesados, substituicao do Metabase |
| Kestra | Orquestracao de dados | Ingestao, ETL/ELT, agendamentos, reprocessamentos, jobs e integracoes tecnicas | Interface final, dashboards executivos, chatbot, automacoes conversacionais |
| Metabase | BI e analytics de negocio | Dashboards, relatorios, comparativos, series historicas e exportacoes | Gestao estrutural da plataforma, pipelines, logs tecnicos, cadastros administrativos |
| Grafana | Observabilidade tecnica | Metricas, logs, alertas, uptime, monitoramento de servicos, banco e infraestrutura | BI de negocio, indicadores publicos, cadastros administrativos, operacao de fluxos |
| PostgreSQL | Persistencia relacional e metadados | Dados estruturados, configuracoes, usuarios, permissoes e camadas tratadas | Armazenamento massivo de arquivos brutos como papel principal |
| MinIO | Data lake e objetos | Arquivos brutos, historico de ingestoes e armazenamento compativel com S3 | Regras transacionais da aplicacao e consultas analiticas como ferramenta final |
| n8n | Automacoes operacionais e AI Hub | Webhooks, integracoes rapidas, chatbot, IA, atendimento digital e canais externos | Data lake, pipelines pesados, BI principal, observabilidade central |
| IoT Hub | Telemetria e sensores | MQTT, eventos, telemetria, alertas e integracao com dispositivos | Papel de BI, portal administrativo ou orquestrador central de dados gerais |
| Apps | Funcionalidades de negocio | Portais, APIs, modulos setoriais e servicos digitais | Substituir componentes especializados de BI, dados ou observabilidade |
| Shared | Capacidade transversal | Autenticacao, contratos, seguranca, DTOs, schemas e padroes comuns | Concentrar regras de negocio especificas de um modulo |

## 5. Fluxo de Funcionamento

Exemplo de fluxo operacional da arquitetura:

1. Uma fonte publica ou sistema municipal envia dados.
2. O modulo CKAN do Symfony cadastra o provedor, consulta `package_list` e persiste o inventario de pacotes.
3. O administrador marca quais pacotes devem entrar em monitoramento.
4. O Core consulta `package_show`, persiste resources e registra `ingestion_runs`.
5. Kestra executa a ingestao automatizada futura.
6. Dados brutos sao armazenados no MinIO.
7. Dados tratados vao para PostgreSQL ou banco analitico futuro.
8. Metabase gera indicadores e dashboards.
9. Symfony apresenta visao central, links, embeds e controle de acesso.
10. Grafana monitora saude dos servicos.
11. n8n atua em automacoes operacionais e IA.
12. IoT Hub, futuramente, recebe sensores e telemetria.

```text
Fonte publica ou sistema municipal
	|
	v
      Kestra
	|
	+--> MinIO (dados brutos)
	|
	v
PostgreSQL / camada analitica futura
	|
	v
     Metabase
	|
	v
     Symfony

Grafana monitora toda a stack
n8n opera automacoes operacionais e IA
IoT Hub evolui como trilha futura para sensores e telemetria
```

## 6. Decisao Arquitetural Oficial

Para o MVP da Plataforma360 serao utilizados:

- Symfony
- Kestra
- PostgreSQL
- MinIO
- Metabase
- Grafana

O n8n sera mantido no AI Hub.

O IoT Hub sera reservado para evolucao futura.

Essa decisao oficial define o escopo inicial da implantacao e evita antecipar componentes que ainda nao sao necessarios para a operacao do MVP.

## 7. Diretrizes de Evolucao

- Evitar duplicacao de dashboards no Symfony.
- Usar Metabase para analytics de negocio.
- Usar Grafana para observabilidade tecnica.
- Usar Kestra para pipelines.
- Usar n8n para automacoes operacionais.
- Manter documentacao atualizada a cada mudanca arquitetural.

Como diretriz complementar, o portal central deve permanecer desacoplado da execucao de pipelines e do armazenamento bruto; a data platform deve continuar separada da automacao conversacional; e a observabilidade deve ser tratada como capacidade tecnica transversal, nao como ferramenta de BI.