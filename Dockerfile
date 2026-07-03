FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev && \
    rm -rf /var/lib/apt/lists/*

# Install the minimum PHP extensions needed to boot Laravel and run migrations.
RUN docker-php-ext-install pdo_mysql pdo_sqlite mbstring

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user

EXPOSE 2000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=2000"]

