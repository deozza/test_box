PROJECT     = test-box
EXEC_PHP    = php
SYMFONY     = $(EXEC_PHP) bin/console
SYMFONY_CLI = symfony
COMPOSER    = composer
.DEFAULT_GOAL := help

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

run: ## Run new test
	$(COMPOSER) install
	$(SYMFONY) doctrine:cache:clear-metadata
	$(SYMFONY) doctrine:database:create
	$(SYMFONY) doctrine:schema:drop --force
	$(SYMFONY) doctrine:schema:create
	$(SYMFONY) hautelook:fixtures:load --purge-with-truncate -q
	$(SYMFONY_CLI) server:ca:install
	$(SYMFONY_CLI) server:start
