fixer: ## Php cs fixer
	./vendor/bin/php-cs-fixer --verbose fix --config=.php-cs-fixer.dist.php

test: ## PHP unit
	./vendor/bin/sail test