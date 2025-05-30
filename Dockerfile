FROM php:8.2-apache

# 安裝 PHP 的 PDO 與 MySQL 驅動
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 複製程式碼到 Apache 網站根目錄
COPY . /var/www/html/

# 啟用 Apache rewrite 模組
RUN a2enmod rewrite

EXPOSE 80
