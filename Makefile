include .env

build:
	UID=$(shell id -u) GID=$(shell id -g) docker-compose build
	@docker-compose run app composer install
up:
	@docker-compose up
stop:
	@docker-compose stop
down:
	@docker-compose down
bash:
	@docker-compose exec app bash
database_schema:
	@docker-compose exec -T database /usr/bin/mysql -u ${MYSQL_ROOT_USER} --password=${MYSQL_ROOT_PASSWORD} ${MYSQL_DATABASE} < migration/schema/users.sql
behat:
	@docker-compose exec app ./vendor/bin/behat --config tests/behat/behat.yml
dump:
	@docker-compose exec app composer dump-autoload
composer:
	@docker-compose exec app composer install
	@docker-compose exec app composer update