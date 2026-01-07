FROM php:8.1-fpm-alpine

# 設定工作目錄
WORKDIR /var/www/html

# 安裝系統依賴
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    icu-dev \
    oniguruma-dev

# 安裝 PHP 擴展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 設定 PHP 配置
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
    && echo "date.timezone = Asia/Taipei" >> "$PHP_INI_DIR/php.ini" \
    && echo "memory_limit = 256M" >> "$PHP_INI_DIR/php.ini" \
    && echo "upload_max_filesize = 20M" >> "$PHP_INI_DIR/php.ini" \
    && echo "post_max_size = 20M" >> "$PHP_INI_DIR/php.ini"

# 設定權限
RUN chown -R www-data:www-data /var/www/html

# 切換使用者
USER www-data

# 暴露端口
EXPOSE 9000

CMD ["php-fpm"]
