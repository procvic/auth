install-dependencies-for-testing:
	composer create-project jakub-onderka/php-parallel-lint temp/php-parallel-lint ~0.9 --no-interaction --prefer-source

test-php-lint:
	php temp/php-parallel-lint/parallel-lint --exclude temp --exclude vendor .
