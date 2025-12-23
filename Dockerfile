FROM php:8.3-apache

# 1. 必要なツール（PostgreSQL用とNode.js用の両方）をインストール
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. PHPの拡張機能（PostgreSQL接続用）をインストール
RUN docker-php-ext-install pdo_pgsql

# 3. Apacheの設定（書き換えを有効にし、ドキュメントルートをpublicに設定）
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY . .

# 4. Composer（PHPの依存関係管理ツール）のインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 5. ★Viteのエラー解決：デザイン（CSS/JS）を組み立てる
RUN npm install && npm run build

# 6. フォルダの権限をRender（Webサーバー）用に設定
RUN chown -R www-data:www-data storage bootstrap/cache public

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# 7. 起動コマンド（DBの箱作りをしてからサーバーを起動）
# ※ db:seed は重複エラーを防ぐため外してあります
CMD php artisan migrate --force && apache2-foreground
