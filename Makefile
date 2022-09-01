CONSOLE_CMD = php bin/console --no-interaction

# LOGS

logs.clean:
	rm -rf var/log/*

# CACHE

cache.clean:
	rm -rf var/cache/*

# PACKAGE

package.install:
	echo | composer install

package.clean:
	rm -rf vendor

# DATABASE

db.drop:
	${CONSOLE_CMD} doctrine:database:drop --force

db.create:
	${CONSOLE_CMD} doctrine:database:create

db.migrate: db.create
	${CONSOLE_CMD} doctrine:migrations:migrate

db.up: db.drop db.create db.migrate fixture.load

# FIXTURES

fixture.load: db.up
	APP_ENV=${APP_ENV} && ${CONSOLE_CMD} doctrine:fixtures:load

# PREPARE

prepare: package.install db.up

prepare.prod: prepare

# RUNNING

run.prod: cache.clean
	chmod -fR 777 var/cache || : && chmod -fR 777 var/log || :

run.dev: cache.clean
	APP_ENV=dev && symfony server:start

run.prod.reset: clean prepare.prod run.prod

run.dev.reset: clean run.dev

# CLEANING

clean: cache.clean logs.clean db.drop package.clean
