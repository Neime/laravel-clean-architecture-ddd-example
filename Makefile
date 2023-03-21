fixer: ## Php cs fixer
	./vendor/bin/php-cs-fixer --verbose fix app/

test: ## PHP unit
	./vendor/bin/sail test