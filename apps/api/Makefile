# Misc
.DEFAULT_GOAL = help
.PHONY        : help docker composer symfony database test

## —— Commands list 🛠️️ —————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


# Executables (local)
DOCKER      = docker
DOCKER_COMP = docker-compose
COMPOSER    = composer
SYMFONY     = bin/console
GIT			= git
PHPUNIT		= bin/phpunit


## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

rm:	down ## Remove the docker hub
	$(DOCKER_COMP) rm -f

start: build up ## Build and start the containers

restart: rm start	## Restart the docker hub

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

bash: ## Connect to the PHP FPM container
	@$(DOCKER) exec -it $(PHP_DOCKERIZED) bash

pgsql: ## Connect to database in postgres container
	@$(DOCKER) exec -it $(DB_DOCKERIZED) psql -U $(DATABASE_USER) $(DATABASE_NAME)

status: ## Docker hub status
	@docker-compose ps


## —— Composer 🧙 ——————————————————————————————————————————————————————————————
update: ## Update composer packages (twice to fix a doctrine deprecation)
	@$(COMPOSER) update

dump: ## dump autoloading
	@$(COMPOSER) dump-autoload

dump-opt: ## Optimize autoloading
	@$(COMPOSER) dump-autoload --optimize

no-lock: ## Remove composer lock
	rm -rf composer.lock

no-vendor: ## Remove vendor
	rm -rf vendor

install-vendor: no-vendor no-lock ## Remove and reinstall vendor
	@$(COMPOSER) install

vendor-up: install-vendor update update dump-autoload ## Remove, reinstall and update vendor	


## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

cc: c=c:c ## Clear the cache
cc: sf

user: c=make:user ## Make user
user: sf

entity: c=m:e ## Make entity
entity: sf

migration: c=make:migration ## Make migrations
migration: sf

router: c=debug:router ## Display routing
router: sf


## —— Grumphp 😡 ———————————————————————————————————————————————————————————————
grum: ## Run grumphp tests
	php ./vendor/bin/grumphp run


## —— Database 🛢️ ——————————————————————————————————————————————————————————————
drop: c=d:d:d --if-exists --force ## Drop database
drop: sf

create: c=d:d:c ## Create database
create: sf

migrate: c=d:s:u -n --force ## Migrations migrate
migrate: sf

drop-test: c=d:d:d --if-exists --force --env=test ## Drop test database
drop-test: sf

create-test: c=d:d:c --env=test ## Create test database
create-test: sf

migrate-test: c=d:s:u -n --env=test --force ## Migrations migrate for test
migrate-test: sf


## —— Fixtures 🤡 ——————————————————————————————————————————————————————————————
load: c=doctrine:fixtures:load -n ## Load fixtures
load: sf

set-db: ## Reset database and seed with fixtures
	make drop && make create && make migrate && make load

load-test: c=doctrine:fixtures:load -n  --env=test## Load test fixtures
load-test: sf

set-db-test: ## Reset test database and seed with fixtures
	make drop-test && make create-test && make migrate-test && make load-test

db:
	make set-db && make set-db-test


## —— Git 🔀 ———————————————————————————————————————————————————————————————————
reset: ## Reset last commit on local
	@$(GIT) reset --soft HEAD^


## —— Tests ✅ —————————————————————————————————————————————————————————————————
phpunit: ## Run all phpunit tests
	@$(eval c ?=)
	@$(PHPUNIT) $(c)

unit: c=tests/Unit/ --testdox ## Run unit tests only
unit: phpunit

endpoint: ## Run end points tests only
	newman run ./postman/test-API-collection.json -e ./postman/env-local.json
