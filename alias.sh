#!/bin/bash
DOCKER_COMPOSE_PATH=.docker
source ${DOCKER_COMPOSE_PATH}/.env
DOCKER_APP="${APP_NAME}"

# php
alias php="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_APP} php";

# php composer
alias composer="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_APP} composer";
