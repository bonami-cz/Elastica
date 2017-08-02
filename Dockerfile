FROM php:5.6
MAINTAINER Nicolas Ruflin <spam@ruflin.com>

RUN apt-get update && apt-get install -y \
	cloc \
	git \
	graphviz \
	nano \
	php5-memcache \
	php5-xsl\
	zip\
	unzip
	# XSL and Graphviz for PhpDocumentor

RUN docker-php-ext-install sockets

RUN rm -r /var/lib/apt/lists/*

# Xdebug for coverage report
RUN pecl install xdebug

## PHP Configuration

RUN echo "memory_limit=1024M" >> /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "date.timezone=UTC" >> /usr/local/etc/php/conf.d/timezone.ini
RUN echo "extension=/usr/lib/php5/20131226/memcache.so" >> /usr/local/etc/php/conf.d/memcache.ini # Enable Memcache
RUN echo "extension=/usr/lib/php5/20131226/xsl.so" >> /usr/local/etc/php/conf.d/xsl.ini # TODO: Debian is putting the xsl extension in a different directory, should be in: /usr/local/lib/php/extensions/no-debug-non-zts-20131226
RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20131226/xdebug.so" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install and setup composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_HOME /root/composer

# Add composer bin to the environment
ENV PATH=/root/composer/vendor/bin:$PATH

COPY composer_root.json /root/composer/composer.json

# Install development tools
RUN composer global install --prefer-source

# ENVIRONMENT Setup - Needed in this image?
ENV ES_HOST elasticsearch
ENV PROXY_HOST nginx

# Install depdencies
WORKDIR /elastica

# Copy composer file first as this only changes rarely
COPY composer.json /elastica/

ENV ELASTICA_DEV true

# Set empty environment so that Makefile commands inside container do not prepend the environment
ENV RUN_ENV " "

# Commands are taken from Makefile. Everytime the makefile is updated, this commands is rerun
RUN mkdir -p \
	./build/code-browser \
	./build/docs \
	./build/logs \
	./build/pdepend \
	./build/coverage
	
RUN composer install --prefer-source

# Copy rest of the files, ignoring .dockerignore files
COPY lib /elastica/lib
COPY test /elastica/test
COPY Makefile /elastica/

ENTRYPOINT []
