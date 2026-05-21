SHELL := /bin/sh
COMPOSE := docker compose
KESTRA_COMPOSE := docker compose -f docker-compose.kestra.yml
PHP := $(COMPOSE) exec php

.PHONY: install up down restart logs bash migrate kestra-up kestra-down kestra-logs kestra-restart

install:
	cp -n .env.example .env || true
	$(COMPOSE) build
	$(COMPOSE) up -d
	$(PHP) php bin/console doctrine:migrations:migrate --no-interaction || true

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) restart

logs:
	$(COMPOSE) logs -f --tail=200

bash:
	$(PHP) sh

migrate:
	$(PHP) php bin/console doctrine:migrations:migrate --no-interaction

kestra-up:
	$(KESTRA_COMPOSE) up -d

kestra-down:
	$(KESTRA_COMPOSE) down

kestra-logs:
	$(KESTRA_COMPOSE) logs -f --tail=200

kestra-restart:
	$(KESTRA_COMPOSE) restart