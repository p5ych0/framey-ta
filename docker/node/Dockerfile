ARG uuid=1000
ARG guid=1000

FROM node:lts-alpine

ARG uuid
ARG guid

RUN apk add shadow curl bash

RUN groupmod -g $guid node && usermod -u $uuid -g $guid node
RUN npm update -g
RUN npm install -g @ionic/cli

WORKDIR /var/www/html

CMD ["yarn", "start"]
