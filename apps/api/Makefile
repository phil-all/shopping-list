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

# Variables
SYSTEM_USER    = 1000


## —— Composer 🧙 ——————————————————————————————————————————————————————————————
update:
	@$(COMPOSER) update

dump:
	@$(COMPOSER) dump-autoload

dump-opt: ## Optimize autoloading
	@$(COMPOSER) dump-autoload --optimize

no-lock:
	rm -rf composer.lock

no-vendor:
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

user: c=make:user ## Create Symfony user
user: sf

entity: c=m:e ## Create Symfony entity
entity: sf

migration: c=make:migration ## Create Symfony migrations
migration: sf

router: c=debug:router ## Display routing
router: sf

entity: ## Create Symfony entity
	@$(SYMFONY) make:entity

test: ## Create Symfony test
	@$(SYMFONY) make:test

fixtures: ## Create Symfony fixtures
	@$(SYMFONY) make:fixtures


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
load: c=doctrine:fixtures:load -n
load: sf

set-db:
	make drop && make create && make migrate && make load

load-test: c=doctrine:fixtures:load -n  --env=test
load-test: sf

set-db-test:
	make drop-test && make create-test && make migrate-test && make load-test

db:  ## Reset databases (dev and test) and load fixtures
	make set-db && make set-db-test


## —— Tests ✅ —————————————————————————————————————————————————————————————————
unit: ## Run unit tests only
	@$(PHPUNIT) tests/Unit/ --testdox

endpoint: ## Run end points tests only
	newman run ./postman/test-API-collection.json -e ./postman/env-local.json


## —— permissions 🛂 ———————————————————————————————————————————————————————————
chown:
	cd .. && chown -R $(SYSTEM_USER) www && cd www

chgrp:
	cd .. && chgrp -R $(SYSTEM_USER) www && cd www

perm: chown chgrp ## change api owner and group
