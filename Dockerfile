FROM php:8.2-fpm

# Installer des dépendances
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd mbstring exif pcntl bcmath

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet dans le conteneur
COPY . .

# Configurer les permissions sur le répertoire de travail
RUN chown -R www-data:www-data /var/www

# Installer les dépendances du projet
RUN composer install

RUN chmod 777 /var/www/secret/odcapp-firebase.json

# Copier le fichier d'environnement et générer la clé
COPY .env.example .env
RUN php artisan key:generate

# Configurer les permissions sur le stockage et le cache
RUN chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Exposer le port 8000 dans le conteneur
EXPOSE 8000

# Lancer le serveur Laravel Artisan
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
