# Make variable for php varsion (look for in .env)
ARG PHP_TAG

# Make container from wodby image
FROM wodby/drupal-php:${PHP_TAG}

# Install necessary extensions
RUN sudo apk --no-cache add php7-dev
RUN pecl update-channels
RUN sudo apk update \
    && sudo apk add --virtual build-dependencies \
        build-base \
        gcc \
        wget \
        git \
    && sudo apk add \
        bash
RUN sudo apk add --no-cache \
    autoconf \
    libmemcached-dev \
    libmemcached \
    cyrus-sasl-plain \
    zlib-dev \
    cyrus-sasl-dev \
    cyrus-sasl

RUN sudo apk update && \
    sudo apk upgrade -U && \
    sudo apk add ca-certificates ffmpeg libwebp libwebp-tools && \
    sudo rm -rf /var/cache/*


# # Installing WEBP tools
# RUN sudo /bin/bash -c 'echo WEBP && \
#   wget -q "http://downloads.webmproject.org/releases/webp/libwebp-0.5.0-linux-x86-64.tar.gz" && \
#   tar -xf libwebp-0.5.0-linux-x86-64.tar.gz && cd libwebp-0.5.0-linux-x86-64/bin && \
#   mv cwebp gif2webp /usr/local/bin/'

# Install memcache extension
# RUN sudo pecl install memcache \
#     && sudo echo "extension=memcache.so" > sudo /usr/local/etc/php/conf.d/php.ini \
#     && sudo touch /usr/local/etc/php/conf.d/docker-php-ext-memcache.ini \
#     && sudo echo "extension=memcache.so" > sudo /usr/local/etc/php/conf.d/docker-php-ext-memcache.ini
