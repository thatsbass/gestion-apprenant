
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
    nginx \
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

# Crée le fichier firebase-key.json à partir de la variable d'environnement base64
RUN echo $FIREBASE_KEY_BASE64 | base64 -d > /var/www/odcapp-firebase.json


# Copier le fichier d'environnement et générer la clé
COPY .env.example .env
RUN php artisan key:generate

# Configurer les permissions sur le stockage et le cache
RUN chown -R www-data:www-data /var/www/storage \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache



# Exposer le port
EXPOSE 80 9000
# Copie le script de démarrage
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["sh", "/usr/local/bin/start.sh"]