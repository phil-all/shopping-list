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


## —— Git 🔀 ———————————————————————————————————————————————————————————————————
reset: ## Reset last commit on local
	@$(GIT) reset --soft HEAD^
