.PHONY: help
help: ## Display this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_0-9-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

.PHONY: run-app
run-app: run-docker-silent composer-install ## Run the app in silent mode for docker and install all needed dependencies

.PHONY: run-docker-silent
run-docker-silent: ## Run the app in silent docker mode
	docker-compose up -d

.PHONY: run-docker-dev
run-docker-dev: ## Run the app
	docker-compose up

.PHONY: build-docker
build-docker: ## Build the app
	docker-compose build --no-cache

.PHONY: composer-install
composer-install: ## composer install
	docker exec -it mini-cms-php composer install

.PHONY: composer-update
composer-update: ## composer update
	docker exec -it mini-cms-php composer update

.PHONY: composer-remove
composer-remove: ## remove composer dependency (make composer-remove dep=YOUR_DEP)
	docker exec -it mini-cms-php composer remove ${dep}

.PHONY: composer-require
composer-require: ## install dependency (make composer-require dep=YOUR_DEP)
	docker exec -it mini-cms-php composer require ${dep}

.PHONY: composer-require-dev
composer-require-dev: ## install dependency (make composer-require-dev dep=YOUR_DEP)
	docker exec -it mini-cms-php composer require --dev ${dep}