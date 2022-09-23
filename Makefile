# Misc
.DEFAULT_GOAL = help
.PHONY        : help docker

## —— Commands list 🛠️️ —————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


# Executables (local)
DOCKER      = docker
DOCKER_COMP = docker-compose
GIT			= git

# Variables
PHP_DOCKERIZED = shopping-list-php


## —— Docker 🐳 ————————————————————————————————————————————————————————————————
build:
	@$(DOCKER_COMP) build --pull --no-cache

up:
	@$(DOCKER_COMP) up --detach

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

rm:	down ## Remove the docker hub
	$(DOCKER_COMP) rm -f

start: build up ## Build and start the containers (no logs)

restart: rm start ## Restart the docker hub

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

status: ## Docker hub status
	@docker-compose ps


## —— Git 🔀 ———————————————————————————————————————————————————————————————————
reset: ## Reset last commit on local
	@$(GIT) reset --soft HEAD^


## —— Front app 💻 —————————————————————————————————————————————————————————————
front: ## start front app node server
	cd apps/front && npm start

api: ## Connect to the api bash
	@$(DOCKER) exec -it $(PHP_DOCKERIZED) bash

pgsql: ## Connect to postgres bash
	docker exec -it shopping-list-postgres psql -U 
