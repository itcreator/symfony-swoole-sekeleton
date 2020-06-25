#!/usr/bin/env bash
set -e


HOST_UID=${HOST_UID:-1000}
HOST_GID=${HOST_GID:-1000}

usermod -u "$HOST_UID" dev
groupmod -g "$HOST_GID" dev


echo "ready"
exec gosu dev "$@"
