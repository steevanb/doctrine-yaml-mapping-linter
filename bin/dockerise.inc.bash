#!/usr/bin/env bash

set -eu

source "${ROOT_PATH}"/bin/docker-interactive-parameter.inc.bash
source "${ROOT_PATH}"/config/docker/docker-image-prefix.inc.bash

if [ -z "${I_AM_CI_DOCKER_CONTAINER:-}" ]; then
    docker \
        run \
            --rm \
            --tty \
            ${DOCKER_INTERACTIVE_PARAMETER} \
            --volume "${ROOT_PATH}":/app \
            --user "$(id -u)":"$(id -g)" \
            --workdir /app \
            --env I_AM_CI_DOCKER_CONTAINER=true \
            --entrypoint /app/bin/"${BIN_SUBDIRECTORY:-}""$(basename "${0}")" \
            "${DOCKER_IMAGE_PREFIX}":ci \
            "${@}"

    exit 0
fi
