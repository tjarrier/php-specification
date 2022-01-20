.PHONY: help
help:
	@echo ""
	@echo "Commands : "
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

SUPPORTED_COMMANDS := phpunit
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  $(eval $(COMMAND_ARGS):;@:)
endif

.PHONY: install
install: ## Install vendors
	composer install

.PHONY: update
update:	## Update vendors
	composer update

.PHONY: clean-vendor
clean-vendor: cc-hard ## Delete vendor folder and reinstall
	rm -Rf vendor
	rm composer.lock
	composer install

.PHONY: phpcs
phpcs: ## Start phpcs
	vendor/bin/phpcbf
	vendor/bin/phpcs --config-set php_version 801010 --exclude=Generic.Files.LineLength

.PHONY: phpstan
phpstan: ## Start phpstan
	vendor/bin/phpstan analyse ./src -c phpstan.neon

.PHONY: deptrac
deptrac: ## Start deptrac
	vendor/bin/deptrac analyse

.PHONY: rector
rector: ## Run rector refactoring
	vendor/bin/rector process

## -- Others --------------------------------------------------------------
.PHONY: build ## Build app
build: install
	cp -n phpunit.xml.dist phpunit.xml
	cp -n phpcs.xml.dist phpcs.xml
	cp -n phpstan.neon.dist phpstan.neon

## -- Others ---------------------------------------------------------------
.PHONY: tests-unit
tests-unit: ## Run phpunit tests
	vendor/bin/phpunit ${COMMAND_ARGS}

.PHONY: tests
tests: ## Run code inspection and all tests
	make phpcs phpstan deptrac tests-unit