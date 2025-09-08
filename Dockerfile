FROM ubuntu:24.04

LABEL maintainer="Taylor Otwell"

ARG NODE_VERSION=22

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y gnupg curl ca-certificates zip unzip git libpng-dev \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y php8.3-cli php8.3-dev \
       php8.3-pgsql php8.3-gd php8.3-curl php8.3-mbstring \
       php8.3-xml php8.3-zip php8.3-bcmath php8.3-soap php8.3-intl \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY . /var/www/html/

RUN groupadd -g 1337 www-data && useradd -u 1337 -g www-data -ms /bin/bash www-data \
    && chown -R www-data:www-data /var/www/html

USER www-data

RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && npm install \
    && npm run build

EXPOSE 10000

CMD ["/usr/bin/php8.3", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]