#!/usr/bin/env bash

set -eu

set +e
tty -s > /dev/null 2>&1 && isInteractiveShell=true || isInteractiveShell=false
set -e
if ${isInteractiveShell}; then
    readonly DOCKER_INTERACTIVE_PARAMETER="--interactive"
else
    readonly DOCKER_INTERACTIVE_PARAMETER=
fi
