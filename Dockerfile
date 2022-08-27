FROM php:apache-stretch

MAINTAINER thenx<opensource@thenx.org>

# ADD sources.list /etc/apt/

RUN apt-get update && apt-get install -y \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg-dir \
    && docker-php-ext-install -j$(nproc) gd


ENV DZ_URL https://discuz.dismall.com/daily/?dl=DZX-SC_UTF8-v3.5-202208190500-474edcd3.zip
ENV DZ_WWW_ROOT /var/www/html

ADD ${DZ_URL} /tmp/discuz.zip
RUN unzip /tmp/discuz.zip \
    && mv upload/* ${DZ_WWW_ROOT} \
    && cd ${DZ_WWW_ROOT} \
    && chmod a+w -R config data uc_server/data uc_client/data \
    && rm -rf /var/lib/apt/lists/*

EXPOSE 80
EXPOSE 443
