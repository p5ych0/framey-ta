ARG uuid=1000
ARG guid=1000

FROM p5ych0/openresty:latest

ARG uuid
ARG guid

RUN addgroup -g $guid docker; \
    adduser --home /var/www/html --gecos "" --uid $uuid --disabled-password --no-create-home --ingroup docker docker
RUN chown docker -R /etc/resty-auto-ssl \
    && chown docker:docker /var/log/nginx \
    && chown docker:docker -R /usr/local/openresty

# Change access righs to conf, logs, bin from root to docker

#setcap to bind to privileged ports as non-root
RUN setcap 'cap_net_bind_service=+ep' /usr/local/openresty/nginx/sbin/nginx
RUN getcap /usr/local/openresty/nginx/sbin/nginx

USER docker
