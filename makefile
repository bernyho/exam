export

RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

SHELL=/bin/bash

COMPOSER=$(SUDO) composer
GULP=$(SUDO) gulp
RUN=$(SUDO) run
YARN=$(SUDO) yarn

################################################################################
# TARGETS

# docker
# ------------------------------------------------------------------------------

stop:
	docker-compose -f .docker/docker-compose.yml down

up:
	docker-compose -f .docker/docker-compose.yml up -d --force-recreate --build

bash:
	docker exec -it test_dockerized-php-1 bash

################################################################################
# ALIASY

start: up
down: stop
#rmcache: clean

# ...and turn them into do-nothing targets
$(eval $(RUN_ARGS):;@:)