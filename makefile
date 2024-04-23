export

RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

SHELL=/bin/bash

COMPOSER=$(SUDO) composer

################################################################################
# DOCKER

stop:
	docker-compose -f .docker/docker-compose.yml down

up:
	docker-compose -f .docker/docker-compose.yml up -d --force-recreate --build

bash:
	docker exec -it exam_php bash

################################################################################
# ALIASY

start: up
down: stop
################################################################################

# ...and turn them into do-nothing targets
$(eval $(RUN_ARGS):;@:)