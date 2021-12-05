ARG uuid=1000
ARG guid=1000

FROM postgres:14-alpine

ARG uuid
ARG guid

RUN apk add shadow libcap

RUN addgroup -g $guid docker; \
    adduser --home /var/www/html --gecos "" --uid $uuid --disabled-password --no-create-home --ingroup docker docker

# Change access righs to conf, logs, bin from root to docker

#setcap to bind to privileged ports as non-root
RUN setcap 'cap_net_bind_service=+ep' /usr/local/bin/postgres
RUN getcap /usr/local/bin/postgres

USER docker
