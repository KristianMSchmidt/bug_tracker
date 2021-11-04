## ----------------------------------------------------------------------
## Makefile for bug_tracker
##
## Used for both development and production. See targets below.
## ----------------------------------------------------------------------

help:   # Show this help.
	@sed -ne '/@sed/!s/## //p' $(MAKEFILE_LIST)

# ---------- Production ---------- #
production_stop: ## Stop production server
	docker-compose -f docker-compose.prod.yml down --remove-orphans

production_start: ## Start production server as daemon
	docker-compose -f docker-compose.prod.yml up --build --remove-orphans -d

production_weblogs: ## Show logs from web container
	docker logs bug-tracker-php

production_traefiklogs: ## Show traefik access logs
	docker logs traefik

production_dblogs: ## Show database access logs
	docker logs bug_tracker_db_1

production_pmalogs: ## Show phpmyadmin access logs
	docker logs phpmyadmin

production_shell: # Open shell in running docker production container
	docker-compose -f docker-compose.prod.yml exec bug-tracker-php /bin/bash

production_db_shell: # Open shell in running docker production container
	docker exec -it bug_tracker_db_1 /bin/bash


