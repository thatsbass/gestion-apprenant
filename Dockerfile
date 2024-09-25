# Utiliser une image officielle de PHP avec FPM (FastCGI Process Manager) version 8.2 
FROM php:8.2-fpm

# Installer les dépendances du système
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le contenu de l'application dans le conteneur
COPY . /var/www

# Définir le répertoire de travail
WORKDIR /var/www

# Installer les dépendances PHP avec Composer
RUN composer install --optimize-autoloader --no-dev

# Créer les répertoires nécessaires et définir les permissions
RUN mkdir -p /var/www/storage/logs /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Créer le fichier de log Laravel et définir les permissions
RUN touch /var/www/storage/logs/laravel.log \
    && chown www-data:www-data /var/www/storage/logs/laravel.log \
    && chmod 664 /var/www/storage/logs/laravel.log

# Configurer PHP-FPM pour s'exécuter en tant que www-data
RUN sed -i 's/user = www-data/user = www-data/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/group = www-data/group = www-data/g' /usr/local/etc/php-fpm.d/www.conf

# Configurer Nginx
COPY nginx/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Exposer les ports
EXPOSE 80 9000

# Copier et exécuter le script de démarrage
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Lancer le script de démarrage quand le conteneur démarre
CMD ["sh", "/usr/local/bin/start.sh"]

