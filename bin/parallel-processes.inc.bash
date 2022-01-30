#!/usr/bin/env bash

set -eu

source "${ROOT_PATH}"/bin/docker-interactive-parameter.inc.bash
source "${ROOT_PATH}"/bin/docker-ids-parameters.inc.bash

docker \
    run \
        --rm \
        --tty \
        ${DOCKER_INTERACTIVE_PARAMETER} \
        --volume "${ROOT_PATH}":"${ROOT_PATH}" \
        --volume "$(which docker)":/usr/bin/docker \
        --volume /var/run/docker.sock:/var/run/docker.sock \
        --env HOST_UID="${DOCKER_UID}" \
        --env HOST_GID="${DOCKER_GID}" \
        --workdir "${ROOT_PATH}" \
        steevanb/php-parallel-processes:parallel-processes-0.3.0 \
        php \
            "${PHP_PATH_NAME}" \
            "${@}"
