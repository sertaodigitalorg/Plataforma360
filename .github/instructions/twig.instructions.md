---
description: "Use when creating or modifying Twig templates in apps/core/templates/. Applies Bootstrap 5.3, Bootstrap Icons and visual patterns of Plataforma360: navy gradient navbar, teal accent #0f766e, card layout, table styles and form conventions."
applyTo: "apps/core/templates/**/*.twig"
---

# Twig/Bootstrap — Convenções da Plataforma360

## Layout

- Todo template admin estende `base.html.twig`
- Conteúdo principal em `<div class="container-fluid py-4">`
- Cabeçalho com `d-flex justify-content-between` (título + botão de ação)

## Cards

```twig
<div class="card border-0 shadow-sm">
    <div class="card-header bg-primary text-white">Título</div>
    <div class="card-body">...</div>
</div>
```

## Tabelas

```twig
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">...</thead>
        <tbody>...</tbody>
    </table>
</div>
```

## Badges de Status

```twig
{# Mapear status para classe Bootstrap #}
{% set badgeClass = {
    'active': 'success', 'success': 'success',
    'failed': 'danger', 'error': 'danger',
    'warning': 'warning', 'degraded': 'warning',
    'running': 'primary', 'pending': 'secondary',
    'inactive': 'secondary', 'resolved': 'info'
} %}
<span class="badge bg-{{ badgeClass[item.status] ?? 'secondary' }}">
    {{ item.status|upper }}
</span>
```

## Ícones

- Sempre Bootstrap Icons: `<i class="bi bi-nome-icone me-1"></i>`
- Nunca SVG inline ou FontAwesome

## Formulários

```twig
<form method="post" novalidate>
    <div class="mb-3">
        <label class="form-label fw-semibold">Campo</label>
        <input type="text" class="form-control" name="campo" value="{{ valor }}" required>
        <div class="invalid-feedback">Campo obrigatório.</div>
    </div>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-floppy me-1"></i>Salvar
    </button>
</form>
```

## Flash Messages

```twig
{% for type, messages in app.flashes %}
    {% for message in messages %}
        <div class="alert alert-{{ type }} alert-dismissible fade show">
            {{ message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    {% endfor %}
{% endfor %}
```

## Confirmação de Delete

```twig
<form method="post" action="{{ path('app_rota_delete', {id: item.id}) }}"
      onsubmit="return confirm('Confirma a exclusão?')">
    <input type="hidden" name="_token" value="{{ csrf_token('delete' ~ item.id) }}">
    <button type="submit" class="btn btn-outline-danger btn-sm">
        <i class="bi bi-trash me-1"></i>Excluir
    </button>
</form>
```

## Datas e Valores

```twig
{{ data|date('d/m/Y H:i') }}
{{ valor|number_format(2, ',', '.') }}
${{ custo|number_format(6, '.', '') }}
```
