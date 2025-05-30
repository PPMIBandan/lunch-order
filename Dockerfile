FROM php:8.2-apache

# 複製所有專案檔案到 Apache 網站根目錄
COPY . /var/www/html/

# 啟用 Apache rewrite 模組（必要時）
RUN a2enmod rewrite

# 暴露 80 埠口
EXPOSE 80