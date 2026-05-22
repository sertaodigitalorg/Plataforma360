# Roadmap

## Fase 1 - Core Instalavel

- Docker Compose com Nginx, PHP 8.3 FPM, PostgreSQL/PostGIS e Adminer.
- Symfony 7 com Doctrine, Twig, Bootstrap 5 e API Platform.
- Homepage institucional, healthcheck e OpenAPI.

## Fase 2 - Dados Territoriais e Pipeline Operacional

- Modelo territorial base.
- Ingestao de dados abertos via modulo CKAN no Core.
- Download fisico de resources para `storage/raw`.
- Registro de metadata operacional em `raw_files`.
- Preview real de datasets CSV/XLSX.
- Descoberta automatica de schema em `dataset_schemas`.
- Organizacao das zonas raw, staging e processed.
- APIs publicas versionadas.
- Modulo CKAN no Core para cadastro de provedores, sincronizacao de `package_list`, consulta de `package_show`, selecao de pacotes monitorados e execucao sincrona da pipeline `download -> raw -> preview -> schema`.

## Fase 3 - Analytics e Observabilidade

- Dashboards territoriais.
- Indicadores turisticos.
- Logs estruturados, metricas e traces.
- Grafana e Superset.
- Evolucao da camada CKAN para verificacao diaria, jobs assincronos e disparo de pipelines Kestra ou Messenger sobre a base operacional ja existente.

## Fase 4 - Data Warehouse, Analytics e Metabase ✅ Implementada

- Camada `warehouse.*` no PostgreSQL com schemas fact/dim/dw.
- Entidade `AnalyticModel` para definir transformações STAGING → WAREHOUSE.
- Serviço `WarehouseTransformationService` — orquestração de transformações analíticas.
- Serviço `MetabaseService` — integração com Metabase (teste de conexão, sync).
- `MetabaseConfig` — configuração de instância Metabase com status de conexão.
- `MetabaseDashboard` — registro e embed de dashboards Metabase.
- `AnalyticsHistory` — trilha de auditoria de todos os eventos analíticos.
- APIs analíticas: `/api/analytics/indicadores`, `/turismo/agencias`, `/ranking`, `/lineage`.
- Linhagem de dados (CKAN → RAW → STAGING → WAREHOUSE → DASHBOARDS).
- Embed responsivo de dashboards via iframe integrado ao visual da plataforma.

## Fase 5 - Camada de Inteligência Artificial Híbrida ✅ Implementada

- **IA Local (Ollama)**: `OllamaService` — chat, embed, listagem de modelos. Perfil Docker `ai` com `ollama` e `qdrant`.
- **IA Externa (OpenAI)**: `OpenAiService` — chat e embeddings com estimativa de custo. Chave armazenada criptografada.
- **Roteamento**: `AiProviderService` — despacha para Ollama ou OpenAI com base no modelo configurado. Bloqueia envio externo por política de contexto.
- **Governança**: `AiGovernanceService` — registra todas as interações em `ai_interactions` com tokens, custo, duração, status e provider.
- **Registro de Prompts**: `AiPromptRepository` + `PromptTemplateService` — templates reutilizáveis com variáveis `{{placeholders}}`.
- **Agentes especializados**: `AiAgentService` + `AiToolRegistryService` — agentes por domínio (turismo, dados públicos, executivo, técnico) com ferramentas de consulta a warehouse, catálogo e indicadores.
- **NL-to-SQL seguro**: `NaturalLanguageSqlService` — converte perguntas em SQL SELECT para o warehouse. Bloqueia DDL/DML.
- **Entidades**: `AiModel`, `AiPrompt`, `AiContext`, `AiAgent`, `AiInteraction`, `AiEmbedding`.
- **Assistente Web**: Chat institucional com histórico, quick prompts, seletor de modelo/contexto/agente e indicador de latência.
- **Menu IA no navbar**: Assistente, Insights, Modelos, Agentes, Contextos, Prompts, Logs, Configurações.
- **Segurança**: API keys nunca em claro, aviso de IA externa, bloqueio por `allowedForExternal`, apenas SELECT no NL-to-SQL, auditoria completa.
- Menu atualizado: Dados → Warehouse/Modelos/Linhagem, Inteligência → Dashboards BI, Integrações → Metabase/APIs Analíticas.
- Manual do usuário em `docs/manual-usuario.md`.

## Fase 5 - Interoperabilidade e IA (Futuro)

- MCP Layer.
- AI Hub.
- Vector DB.
- Conectores com sistemas públicos.
- Automação Kestra avançada.