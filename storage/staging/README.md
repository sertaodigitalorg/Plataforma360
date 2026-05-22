# Staging Layer — Plataforma360

Esta camada armazena datasets semi-processados e normalizados derivados dos arquivos RAW.

## Estrutura

```
storage/staging/{provider}/{dataset}/{year}/{month}/
```

## Importante

- Staging NÃO substitui RAW
- Staging é derivado do RAW
- Staging será a base para o warehouse analítico (futuro)
