FROM php:7.4-fpm

RUN groupadd -r dev && useradd -r -m -g dev dev
#USER dev

#TODO: clean apt cache
RUN apt-get update -y
RUN apt-get install -y \
        gosu \
        sudo \
        curl \
        libbz2-dev \
        libcurl4-openssl-dev \
        libmcrypt-dev \
        libonig-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
    && rm -rf /var/lib/apt/lists/*

COPY ./ops/docker/php/entrypoint.sh /bin/entrypoint.sh
ENTRYPOINT ["/bin/entrypoint.sh"]
#CMD ["-c"]

WORKDIR /code


RUN \
    docker-php-ext-configure bcmath --enable-bcmath \
#    && docker-php-ext-configure pdo_pgsql --with-pgsql \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-install \
        bcmath \
        intl \
        curl \
        mbstring \
        pdo_pgsql \
        sockets \
        zip \
        opcache \
    && pecl install \
        mcrypt \
        swoole \
        xdebug \
    && docker-php-ext-enable \
        mcrypt \
        swoole
#        xdebug

RUN apt-get update -y
RUN apt-get install -y git
RUN cd /tmp && git clone https://github.com/swoole/sdebug.git && cd sdebug && sudo ./rebuild.sh \
    && cd /tmp && rm -Rf /tmp/sdebug

COPY ./ops/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./ops/docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
EXPOSE 8080

RUN apt-get install -y \
    procps \
    net-tools \
    unzip \
    vim