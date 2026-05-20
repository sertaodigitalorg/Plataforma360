SHELL := /bin/sh
COMPOSE := docker compose
PHP := $(COMPOSE) exec php

.PHONY: install up down restart logs bash migrate

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