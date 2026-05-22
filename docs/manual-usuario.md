# Manual do Usuário — Plataforma360

## Guia Passo a Passo: Da Ingestão até os Dashboards

Este manual descreve a ordem correta para cadastrar e operar cada funcionalidade da Plataforma360, desde a origem dos dados até a publicação de dashboards analíticos.

---

## Ordem de Operação Recomendada

```
1. Provedor de Dados (CKAN)
2. Pacotes CKAN
3. Ingestão de Dados (RAW)
4. Mapeamento de Colunas
5. Transformação → STAGING
6. Qualidade dos Dados
7. Catálogo de Datasets
8. Modelos Analíticos (Warehouse)
9. Configuração Metabase
10. Registro de Dashboards
11. Incorporação (Embed) de Dashboards
```

---

## 1. Cadastrar Provedor de Dados

**Menu:** Dados → Provedores de Dados

Um **provedor de dados** é um endpoint CKAN público (ex: Portal Brasileiro de Dados Abertos do Turismo).

**Como cadastrar:**
1. Acesse **Dados → Provedores de Dados → Novo Provedor**
2. Preencha:
   - **Nome:** Identificação interna (ex: "MTUR - Cadastur")
   - **URL Base:** Endereço raiz da API CKAN (ex: `https://dados.turismo.gov.br`)
   - **Path Package List:** `/api/3/action/package_list`
   - **Path Package Show:** `/api/3/action/package_show?id={package_id}`
3. Marque **Ativo**
4. Clique em **Salvar**

Após salvar, clique em **Sincronizar** para buscar os pacotes disponíveis.

---

## 2. Selecionar Pacotes CKAN para Monitoramento

**Menu:** Dados → Pacotes CKAN

**Como configurar:**
1. Acesse **Dados → Pacotes CKAN**
2. Localize o pacote desejado (ex: "agencias-turismo")
3. Clique em **Monitorar** para ativar o download automático
4. Clique em **Detalhar** para visualizar os resources disponíveis (CSV, XLSX, etc.)

---

## 3. Executar a Ingestão de Dados

**Menu:** Dados → Ingestão de Dados

A ingestão faz o **download físico** dos arquivos do provedor para `storage/raw/`.

**Como executar:**
1. Acesse **Dados → Ingestão de Dados**
2. Localize a execução desejada e clique em **Baixar Arquivos**
3. Acompanhe o status: `pending → running → success`
4. Após o download, acesse **Dados → Arquivos RAW** para confirmar os arquivos

---

## 4. Fazer Preview do Dataset

**Menu:** Dados → Preview Dataset

Antes de transformar, visualize o conteúdo do arquivo.

**Como usar:**
1. Acesse **Dados → Preview Dataset**
2. Selecione o arquivo desejado
3. Verifique:
   - Colunas detectadas automaticamente
   - Tipos de dados inferidos
   - Amostras dos primeiros registros
   - Encoding do arquivo

---

## 5. Configurar Mapeamento de Colunas

**Menu:** Dados → Mapeamento (Fase 3)

O mapeamento define como as colunas do arquivo original serão normalizadas.

**Como configurar:**
1. Acesse **Dados → Mapeamento**
2. Selecione o pacote/arquivo
3. Para cada coluna, defina:
   - **Coluna normalizada:** nome padronizado (ex: `nome_municipio`)
   - **Tipo de dado:** string, integer, decimal, date, boolean
   - **Regra de normalização:** trim, upper, lower, slug, etc.
   - **Obrigatório:** se o campo é requerido
4. Salve o mapeamento

---

## 6. Executar Transformação para STAGING

**Menu:** Dados → Preview Staging

A transformação aplica o mapeamento e grava os dados normalizados no STAGING.

**Como executar:**
1. Acesse **Dados → Arquivos RAW**
2. Localize o arquivo e clique em **Transformar**
3. O sistema executa: normalização → validação → relatório de qualidade → importação staging
4. Após concluído, acesse **Dados → Preview Staging** para confirmar

---

## 7. Verificar Qualidade dos Dados

**Menu:** Dados → Qualidade (Fase 3)

**Como verificar:**
1. Acesse **Dados → Qualidade**
2. Visualize por dataset:
   - **Score de qualidade** (0–100%)
   - Total de linhas válidas, inválidas e duplicadas
   - Campos nulos
   - Erros de validação detalhados

Datasets com score abaixo de 70% devem ser revisados antes de ir ao Warehouse.

---

## 8. Visualizar o Catálogo de Datasets

**Menu:** Dados → Catálogo (Fase 3)

O catálogo lista todos os datasets normalizados prontos para análise.

**Como usar:**
1. Acesse **Dados → Catálogo**
2. Pesquise por nome, tipo ou provedor
3. Clique em um dataset para ver seu schema detalhado

---

## 9. Criar Modelo Analítico (Warehouse)

**Menu:** Dados → Modelos Analíticos

Um **modelo analítico** define como os dados do STAGING serão transformados em tabelas otimizadas no **Warehouse**.

**Como criar:**
1. Acesse **Dados → Modelos Analíticos → Novo Modelo**
2. Preencha:
   - **Nome:** Identificação do modelo (ex: "Agências de Turismo por Estado")
   - **Tabela Origem:** tabela staging (ex: `staging_agencias_turismo`)
   - **Tabela Destino:** tabela warehouse (ex: `warehouse.dw_agencias_turismo`)
   - **Dimensões:** colunas de agrupamento (ex: `estado,municipio,regiao`)
   - **Métricas:** colunas numéricas (ex: `total_agencias`)
   - **Estratégia de Atualização:** manual, diário, horário ou semanal
3. Clique em **Criar modelo**
4. Na listagem, clique no botão ▶ para **executar a transformação**

Após executar, o status muda para **Pronto** e a tabela é criada no schema `warehouse` do PostgreSQL.

---

## 10. Visualizar o Warehouse

**Menu:** Dados → Data Warehouse

Após executar modelos, acesse o painel do Warehouse para verificar:
- Tabelas geradas no schema `warehouse`
- Número de linhas por tabela
- Histórico de execuções e transformações

---

## 11. Configurar Integração com Metabase

**Menu:** Integrações → Metabase

O Metabase se conecta **diretamente ao PostgreSQL Warehouse** e gera dashboards analíticos.

**Pré-requisito:** ter o Metabase rodando (veja `docker-compose.yml` ou instância externa).

**Como configurar:**
1. Acesse **Integrações → Metabase**
2. Preencha:
   - **URL Base:** endereço da sua instância Metabase (ex: `http://localhost:3000`)
   - **Nome do Banco:** como o banco está cadastrado no Metabase
   - **Usuário / Senha:** credenciais do Metabase
   - **Secret Key:** chave para embedding (opcional — necessária para incorporação)
3. Clique em **Salvar Configuração**
4. Clique em **Testar Conexão** para verificar

**No Metabase (configuração inicial):**
1. Acesse o Metabase via browser
2. Vá em **Admin → Databases → Add database**
3. Selecione **PostgreSQL**
4. Configure: host `postgres`, porta `5432`, database `app`, schema `warehouse`
5. Salve e aguarde sincronização

---

## 12. Registrar Dashboards do Metabase

**Menu:** Inteligência → Dashboards BI (ou Integrações → Metabase → Dashboards)

**Como registrar:**
1. No Metabase, crie seu dashboard com as perguntas desejadas
2. Para obter a URL de incorporação: clique em **Compartilhar → Incorporar no site**
3. Copie a URL gerada
4. Na Plataforma360, acesse **Integrações → Metabase → Dashboards → Registrar Dashboard**
5. Preencha:
   - **Nome:** nome do dashboard
   - **URL de Embed:** URL copiada do Metabase
   - **Dataset:** tabela warehouse utilizada (ex: `warehouse.dw_agencias_turismo`)
   - **Origem:** fonte dos dados (ex: "Cadastur / MTUR")
   - Marque **Permitir incorporação**
6. Clique em **Registrar dashboard**

---

## 13. Abrir Dashboard Incorporado

**Menu:** Inteligência → Dashboards BI

1. Na listagem de dashboards, clique no botão 👁 (Abrir)
2. O dashboard do Metabase será carregado via **iframe** dentro da plataforma
3. Metadados como dataset, origem e tipo são exibidos abaixo do dashboard

---

## 14. Visualizar Indicadores Executivos

**Menu:** Inteligência → Indicadores

O painel de indicadores exibe KPIs estratégicos calculados a partir do warehouse:
- Total de agências cadastradas
- Estados e municípios atendidos
- Tendências e comparativos

---

## 15. Usar as APIs Analíticas

As APIs analíticas estão disponíveis em `/api/analytics/`:

| Endpoint | Descrição |
|---|---|
| `GET /api/analytics/indicadores` | Indicadores executivos do warehouse |
| `GET /api/analytics/turismo/agencias` | Dados de agências com ranking |
| `GET /api/analytics/turismo/municipios` | Ranking por estado |
| `GET /api/analytics/ranking` | Ranking + série temporal mensal |
| `GET /api/analytics/lineage` | Linhagem de dados (contagens por camada) |
| `GET /api/analytics/models` | Lista de modelos analíticos ativos |

**Exemplo de uso:**
```bash
curl https://sua-plataforma.gov.br/api/analytics/indicadores
```

---

## 16. Visualizar Linhagem de Dados

**Menu:** Dados → Linhagem

O painel de linhagem mostra o fluxo completo dos dados:

```
CKAN → RAW → STAGING → WAREHOUSE → INDICADORES → DASHBOARDS
```

Para cada camada, você vê a contagem de itens processados e se está ativa.

---

## Fase 5 — Inteligência Artificial Híbrida

> **Pré-requisito:** iniciar com o perfil `ai`: `docker compose --profile ai up -d`

### 17. Usar o Assistente de IA

**Menu:** IA → Assistente

O assistente permite fazer perguntas em linguagem natural sobre os dados da plataforma.

**Como usar:**
1. Acesse **IA → Assistente**
2. Selecione na barra lateral:
   - **Modelo:** Ollama local (gratuito, soberano) ou OpenAI (externo, pago)
   - **Contexto:** define quais dados o assistente pode consultar
   - **Agente:** especialização do assistente (turismo, executivo, técnico, etc.)
3. Digite sua pergunta, ex: *"Quantas agências de turismo estão cadastradas por estado?"*
4. O assistente consulta o warehouse e responde em linguagem natural

**Quick prompts disponíveis:**
- Análise de indicadores de turismo
- Relatório executivo mensal
- Qualidade dos dados por dataset
- Comparativo territorial

---

### 18. Configurar Modelos de IA

**Menu:** IA → Modelos

**Como adicionar um modelo Ollama (local):**
1. Acesse **IA → Modelos → Novo Modelo**
2. Provedor: `ollama`
3. Nome do modelo: `llama3`, `mistral`, `codellama`, etc.
4. Endpoint: `http://ollama:11434` (padrão)
5. Marque **Modelo padrão** se for o principal
6. Salve

> Para baixar o modelo: `docker compose exec ollama ollama pull llama3`

**Como adicionar OpenAI (externo):**
1. Provedor: `openai`
2. Nome do modelo: `gpt-4o-mini`, `gpt-4o`
3. Cole a API Key no campo correspondente
4. Atenção: interações externas têm custo e são auditadas

---

### 19. Gerenciar Agentes Especializados

**Menu:** IA → Agentes

Agentes são configurações especializadas por domínio com ferramentas específicas.

| Agente | Especialidade | Ferramentas |
|---|---|---|
| Turismo | Dados do setor de turismo | buscar_indicadores, consultar_warehouse |
| Dados Públicos | Catálogo CKAN | listar_datasets, obter_qualidade |
| Executivo | Relatórios de gestão | gerar_relatorio, comparativo territorial |
| Técnico | Qualidade e linhagem | obter_linhagem_dataset, consulta SQL |

---

### 20. Consultar Logs de IA

**Menu:** IA → Logs

Exibe todas as interações com o assistente, incluindo:
- Provedor e modelo utilizado
- Tokens consumidos (entrada + saída)
- Custo estimado em USD
- Status (sucesso/falha)
- Se foi via provedor externo

---

## Fase 6 — Operações e Governança

### 21. Visão Geral de Operações

**Menu:** Operações → Visão Geral

Dashboard com KPIs operacionais em tempo real:
- Pipelines ativos / falhas hoje
- Alertas críticos
- Status geral dos serviços
- Execuções recentes
- Alertas recentes

---

### 22. Gerenciar Pipelines

**Menu:** Operações → Pipelines

Pipelines são fluxos de dados orquestrados pelo Kestra.

**Como cadastrar um pipeline:**
1. Acesse **Operações → Pipelines → Novo Pipeline**
2. Preencha:
   - **Nome** e **Tipo** (ingestão, transformação, warehouse, embeddings, etc.)
   - **Trigger** (manual, cron, evento, webhook)
   - **Cron Expression** (se agendado, ex: `0 2 * * *`)
   - **Kestra Namespace** (ex: `plataforma360`)
   - **Kestra Flow ID** (ex: `ingestao-ckan-turismo`)
   - **Kestra YAML** (definição do flow para referência)
3. Salve

**Para disparar manualmente:**
- Clique no botão ▶ na linha do pipeline
- A execução aparece em **Operações → Execuções**

**Para pausar/retomar:**
- Clique no botão ⏸/▶ na coluna de ações

---

### 23. Acompanhar Execuções

**Menu:** Operações → Execuções

Lista todas as execuções com:
- Status (CREATED, RUNNING, SUCCESS, FAILED, CANCELLED)
- Pipeline associado
- Quem disparou e quando
- Duração

Clique no ícone 👁 para ver o **detalhe da execução** com:
- Logs completos
- Inputs e outputs
- Mensagem de erro (se falhou)
- Sync automático com o status no Kestra

---

### 24. Observabilidade dos Serviços

**Menu:** Operações → Observabilidade

Verificação em tempo real da saúde de todos os serviços:

| Serviço | O que é verificado |
|---|---|
| Symfony | Memória do processo PHP |
| PostgreSQL | Latência, contagem de tabelas |
| Kestra | Disponibilidade da API |
| Ollama | Disponibilidade + modelos carregados |
| Qdrant | Status da API |
| Metabase | Status da API |
| Storage | Diretórios raw/staging acessíveis |

---

### 25. Gerenciar Alertas

**Menu:** Operações → Alertas

Alertas são gerados automaticamente por falhas de pipeline, serviços offline ou anomalias.

**Ações disponíveis:**
- **Reconhecer (✓):** marca como visto, registra o responsável
- **Resolver (✓✓):** marca como resolvido

Os níveis são: `info`, `warning`, `critical` — críticos aparecem destacados em vermelho.

---

### 26. Governança de Dados (LGPD)

**Menu:** Governança → Dados

Registre a política de governança de cada dataset:

1. Acesse **Governança → Dados → Novo Registro**
2. Preencha:
   - **Classificação:** público, interno, restrito, sensível
   - **Sensibilidade:** nenhuma, baixa, média, alta
   - **Aplica-se LGPD:** marque se o dataset contém dados pessoais
   - **Base Legal LGPD:** consentimento, obrigação legal, interesse legítimo, etc.
   - **Responsável (Owner)** e **Steward**
   - **Retenção (dias):** política de retenção dos dados

---

### 27. Rastrear Custos

**Menu:** Governança → Custos

Acompanhe os custos de serviços externos (principalmente OpenAI):
- Total do mês atual em USD
- Breakdown por serviço
- Série diária dos últimos 30 dias

> Serviços locais como Ollama e Qdrant têm custo zero.

---

### 28. Consultar Auditoria

**Menu:** Governança → Auditoria

Trilha completa de todas as ações administrativas:
- **Filtro por ação:** `pipeline_run`, `config_change`, `ai_query`, etc.
- **Filtro por usuário:** busca por e-mail ou identifier
- Cada entrada registra: ação, descrição, entidade, usuário, IP e data/hora

---

## Resumo do Fluxo Completo (Fases 1–6)

```
[1] Provedor CKAN
    ↓ sincronizar pacotes
[2] Pacotes CKAN
    ↓ monitorar + baixar
[3] Arquivos RAW
    ↓ configurar mapeamento
[4] Mapeamento de Colunas
    ↓ executar transformação
[5] STAGING (dados normalizados)
    ↓ verificar qualidade
[6] Relatório de Qualidade
    ↓ criar modelo analítico
[7] Modelo Analítico
    ↓ executar transformação
[8] WAREHOUSE (tabelas analíticas)
    ↓ configurar Metabase
[9] Metabase (conectado ao warehouse)
    ↓ criar dashboards no Metabase
    ↓ registrar na plataforma
[10] Dashboards incorporados
     ↓
[11] Indicadores + APIs Analíticas
     ↓
[12] Assistente de IA (consulta warehouse em linguagem natural)
     ↓
[13] Pipelines Kestra (orquestração automatizada)
     ↓
[14] Operações + Alertas + Observabilidade
     ↓
[15] Governança LGPD + Auditoria + Custos
```
