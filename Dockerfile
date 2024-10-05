FROM dunglas/frankenphp AS frankenphp
SHELL ["/bin/bash", "-euxo", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN \
    # Install OS packages
    apt-get update; \
    apt-get -y --no-install-recommends install \
        acl \
        git \
        libnss3-tools \
        openssh-client \
        unzip \
    ; \
    # Configure OS
    install-php-extensions \
        @composer \
        apcu \
        intl \
        opcache \
        zip \
    ; \
    # Configure PHP
    { \
        echo apc.enable_cli = 1; \
        echo memory_limit = 256M; \
        echo opcache.interned_strings_buffer = 16; \
        echo opcache.max_accelerated_files = 20000; \
        echo opcache.memory_consumption = 256; \
        echo realpath_cache_ttl = 600; \
        echo session.use_strict_mode = 1; \
    } >> "$PHP_INI_DIR/conf.d/10-php.ini"; \
    # Install Node.js
    curl -fsSL "https://deb.nodesource.com/setup_current.x" | bash -; \
    apt-get install -y --no-install-recommends nodejs; \
    npm install -g yarn; \
    # Cleanup
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*
