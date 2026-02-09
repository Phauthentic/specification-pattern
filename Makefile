.PHONY: help test phpstan shell install deps build up down

# Default target
help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

# Docker commands
build: ## Build the PHP container
	docker-compose build

up: ## Start the PHP container
	docker-compose up -d

down: ## Stop the PHP container
	docker-compose down

shell: ## Login to the PHP container
	docker-compose exec php bash

# Development commands
install: up ## Install PHP dependencies
	docker-compose exec php composer install

deps: install ## Alias for install

test: up deps ## Run PHPUnit tests
	docker-compose exec php bin/phpunit

phpstan: up deps ## Run PHPStan static analysis
	docker-compose exec php bin/phpstan analyse src -l 8

phpcs: up deps ## Run PHP CodeSniffer
	docker-compose exec php bin/phpcs --standard=phpcs.xml src

# Combined commands
check: phpstan phpcs ## Run static analysis and code style checks

all: test check ## Run all tests and checks