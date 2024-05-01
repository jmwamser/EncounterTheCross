.DEFAULT_GOAL := help
.PHONY: $(filter-out vendor node_modules,$(MAKECMDGOALS))

# should run this with the 'symfony php' so the script switches to the correct php version. I have an alias for this though
bin = vendor/bin
php_bin := symfony php $(bin)

help: ## This help message
	@printf "\033[33mUsage:\033[0m\n  make [target]\n\n\033[33mTargets:\033[0m\n"
	@grep -E '^[-a-zA-Z0-9_\.\/]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[32m%-15s\033[0m %s\n", $$1, $$2}'

# Aliases
precommit: cs-fixer lint phpstan ## Run style fixing and linting commands
scan: cs-fixer lint phpmd phpstan ## Run all scans including mess detection and static analysis
baseline: phpstan-baseline phpmd-baseline ## Generate baselines for mess detection and static analysis
build: versions clean vendor node_modules precommit ## Recompile all assets from scratch

# Version Management
# Requires installing valet. (Not included by default).
versions: ## Set PHP version
	@valet use php@8.2

## Build Processes
vendor: composer.json composer.lock ## Install PHP dependencies
	@composer install --quiet -n
	@echo "PHP dependencies installed."

node_modules: package.json package-lock.json ## Install Node modules
	check_fnm
	@npm install --silent
	@echo "Npm dependencies installed."

check_fnm:
	@if ! command -v fnm &> /dev/null; then \
		echo "fnm is not installed. It is recommended to install it from https://github.com/Schniz/fnm, for NODE project management."; \
		exit 1; \
	fi

clean: ## Removes all build dependencies (vendor, node_modules)
	@rm -rf vendor/ node_modules/ public/build/ public/bundles/ bin/local-php-security-checker
	@echo "Dependencies removed."

# Build Tooling
cs-fixer: ## Code styling fixer
	@$(php_bin)/php-cs-fixer fix --config=.php-cs-fixer.php --quiet

lint: ## PHP, YAML & Twig Syntax Checking
	@$(php_bin)/parallel-lint -j 10 src/ --no-progress --colors --blame && bin/console lint:yaml config/ && bin/console lint:twig templates/

lint-ci:
	$(bin)/parallel-lint -j 10 src/ --no-progress --colors --checkstyle > report.xml && bin/console lint:yaml -n config/ && bin/console lint:twig -n templates/

phpmd: ## PHP Mess Detection
	@$(php_bin)/phpmd src/ ansi phpmd.xml

phpmd-ci:
	@$(bin)/phpmd src/ github phpmd.xml

phpmd-baseline: ## PHP Mess Detection. Generate Baseline
	@$(php_bin)/phpmd src/ ansi phpmd.xml --generate-baseline

phpstan: ## PHP Static Analyzer
	@$(php_bin)/phpstan analyse --memory-limit 512M --error-format=table --configuration=phpstan.neon

phpstan-ci:
	@$(bin)/phpstan analyse --memory-limit=512M --no-progress --error-format=github --configuration=phpstan.dist.neon

phpstan-baseline: ## PHP Static Analyzer. Generate Baseline.
	@$(php_bin)/phpstan analyse --memory-limit 512M --error-format=table --configuration=phpstan.neon --generate-baseline=phpstan-baseline.neon --allow-empty-baseline

# Testing. Requires installing Pest. (Not included by default).
pest: ## PHP Tests (extended off PHPUnit)
	$(php_bin)/pest --colors=always -c build/pest/phpunit.xml

unit-tests: # PHPUnit Tests
	vendor/bin/phpunit --testsuite unit

integration-tests:  # PHPUnit Tests
	vendor/bin/phpunit --testsuite integration

acceptance-tests:  # PHPUnit Tests
	vendor/bin/behat -v --suite=acceptance