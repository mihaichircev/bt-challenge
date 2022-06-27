FROM php:8.1-fpm

ENV TZ=Europe/Bucharest
ENV UID=1000
ENV GID=1000

RUN apt-get --allow-releaseinfo-change update \
  && apt-get install -y \
  zlib1g-dev \
  libicu-dev \
  g++ \
  librabbitmq-dev \
  libmemcached-dev \
  libz-dev \
  libpq-dev \
  libssl-dev \
  libmcrypt-dev \
  libzip-dev \
  zlib1g-dev \
  gettext-base \
  sudo \
  vim \
  zip \
  memcached
  
RUN docker-php-ext-configure intl

RUN apt-get update \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install bcmath \  
  && docker-php-ext-install sockets \  
  && docker-php-ext-install zip \
  && docker-php-ext-install intl \
  && pecl install amqp memcached \
  && docker-php-ext-enable amqp memcached opcache

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Setup the Composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php \
  && php -r "unlink('/tmp/composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer