# Environment variables
DOCKER_COMPOSE = docker compose
DOCKER_EXEC = docker compose exec -it app

# Build the project
build:
	$(DOCKER_COMPOSE) up -d

# Para o projeto
stop:
	$(DOCKER_COMPOSE) down

# Run tests
test:
	$(DOCKER_EXEC) bash -c "php artisan test"

# Run the project
run:
	$(DOCKER_COMPOSE) up -d && $(DOCKER_EXEC) bash -c "composer install && php artisan key:generate && php artisan migrate:refresh && php artisan db:seed && php artisan test && echo 'Finalizado....' "


# Initialize the project
init:
	$(DOCKER_COMPOSE) exec app bash
