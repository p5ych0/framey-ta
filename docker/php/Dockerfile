ARG uuid=1000
ARG guid=1000

FROM p5ych0/php-fpm:v8.0-cli

ARG uuid
ARG guid

RUN addgroup -g $guid docker; \
    adduser --home /var/www/html --gecos "" --uid $uuid --disabled-password --no-create-home --ingroup docker docker
RUN apk add nodejs npm

# Change access righs to conf, logs, bin from root to docker

#setcap to bind to privileged ports as non-root
RUN setcap 'cap_net_bind_service=+ep' /usr/local/bin/php
RUN getcap /usr/local/bin/php

# USER docker
