FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip mbstring

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create php user with same UID/GID as host user to avoid permission issues
RUN groupadd -g 1000 php && \
    useradd -u 1000 -g 1000 -m -s /bin/bash php

# Set working directory
WORKDIR /app

# Change ownership of the working directory to php user
RUN chown -R php:php /app

# Switch to php user
USER php

# Keep container running
CMD ["tail", "-f", "/dev/null"]