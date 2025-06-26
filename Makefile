DOCKER_COMPOSE  = DOCKER_BUILDKIT=1 docker compose

start-fast:
	$(DOCKER_COMPOSE) up -d

start: ## start containers (build and pull updates if needed)
	$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --pull
	$(DOCKER_COMPOSE) up -d --remove-orphans --no-recreate

stop: ## stop containers
	$(DOCKER_COMPOSE) stop

php: ## enter the webserver container
	$(DOCKER_COMPOSE) exec php-fpm sh

mysql: ## enter the webserver container
	$(DOCKER_COMPOSE) exec mysql sh
