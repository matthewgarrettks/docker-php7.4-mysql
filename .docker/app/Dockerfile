FROM ubuntu:20.04

ENV DEBIAN_FRONTEND="noninteractive" \
    TZ="America/Chicago"

ADD https://github.com/just-containers/s6-overlay/releases/download/v2.1.0.0/s6-overlay-amd64.tar.gz /tmp/
RUN tar xzf /tmp/s6-overlay-amd64.tar.gz -C / --exclude='./bin' && tar xzf /tmp/s6-overlay-amd64.tar.gz -C /usr ./bin

RUN set -eux; \
    echo $TZ > /etc/timezone; \
    apt update; \
    apt install -y  \
    curl \
    gnupg2 \
    openssl \
    wget; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

# Add nodejs yarn repository
RUN set -eux; \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -; \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN set -eux; \
    apt update; \
    apt install -y --no-install-recommends \
    git \
    nginx \
    nodejs \
    openssh-client \
    yarn \
    php7.4-curl \
    php7.4-fpm \
    php7.4-gd \
    php7.4-ldap \
    php7.4-mbstring \
    php7.4-mysql \
    php7.4-pgsql \
    php7.4-readline \
    php7.4-sqlite3 \
    php7.4-xdebug \
    php7.4-xml \
    php7.4-zip \
    sqlite3 \
    unzip; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

RUN mkdir -p /run/php

RUN useradd app -m -r

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/home/app/.composer

RUN set -eux; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    chown -R app:app ${COMPOSER_HOME}

RUN set -eux; \
    mkdir -p /app/project/vendor; \
    mkdir -p /app/project/var; \
    mkdir -p /app/project/node_modules; \
    chown -R app:app /app

COPY ./etc /etc
COPY ./nginx/fastcgi_params /etc/nginx/fastcgi_params
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./nginx/vhost.conf /etc/nginx/sites-available/default
COPY ./php/ /etc/php/

ENV APP_ENV="dev" \
    GIT_REPO="" \
    GIT_USER="" \
    GIT_TOKEN="" \
    GIT_TAG="develop" \
    IS_SYMFONY="0" \
    IS_DEV="0"

WORKDIR /app

EXPOSE 80 443

CMD ["/init"]
