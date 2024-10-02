<p align="center">
  <img src="https://www.docker.com/wp-content/uploads/2022/03/Moby-logo.png" alt="Docker Logo" width="200"/>
</p>


that demonstrates the installation and configuration of `Docker` with `Laravel`:

---

# Laravel Docker Setup

This project demonstrates how to set up a Docker environment for a Laravel application using `nginx`, `php-fpm`, and `PostgreSQL`.

## Prerequisites

Ensure you have the following installed on your machine:
- [Docker](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/thatsbass/docker-config.git
cd docker-config
```

### 2. Create `.env` File

Create a `.env` file in the root of your Laravel project based on `.env.example`:

```bash
cp .env.example .env
```

Modify the necessary environment variables, especially database credentials to match your Docker setup. For example:

```bash
DB_CONNECTION=pgsql
DATABASE_URL=your_url_Neon
```

### 3. Build and Run Docker Containers

Build and start your Docker containers using Docker Compose:

```bash
docker-compose up --build
```

This will start:
- A `PHP 8.2` container running Laravel with PHP-FPM.
- An `nginx` container serving the Laravel application.
- Your PostgreSQL database (hosted externally).

### 4. Accessing the Application

Once the containers are up and running, you can access the application by navigating to `http://localhost:2025` in your browser.

### 5. Run Laravel Migrations

Once the Docker containers are running, open a terminal inside the `app` container and run the following commands to migrate the database:

```bash
docker exec -it laravel_app bash
php artisan migrate
```

## Docker Compose Configuration

Below is an explanation of the services defined in the `docker-compose.yml` file:

### App Service
- **Image:** Custom-built using the provided `Dockerfile`.
- **Container name:** `laravel_app`.
- **Volume:** Mounts the current project directory into the `/var/www` folder inside the container.
- **Environment variables:** Includes the `DATABASE_URL` for PostgreSQL.
- **Exposed ports:** Exposes port `9000` for PHP-FPM communication with Nginx.

### Webserver Service
- **Image:** The official Nginx image.
- **Container name:** `laravel_nginx`.
- **Depends on:** `app` service to ensure it starts after the app container is up.
- **Ports:** Maps port `80` inside the container to port `2025` on the host.
- **Volumes:** Mounts the `nginx` configuration and the Laravel project files.

## Dockerfile Configuration

The `Dockerfile` defines how the `app` service is built:
- **PHP 8.2 with FPM:** The base image uses PHP 8.2 with FastCGI Process Manager.
- **System dependencies:** Installs necessary packages including `zip`, `gd`, `curl`, and others.
- **Composer:** Installs dependencies using Composer.
- **Permissions:** Configures permissions for the `storage` and `bootstrap/cache` directories.
- **Nginx configuration:** Copies custom Nginx configuration into the container.
- **Port exposure:** Exposes port `80` for Nginx and port `9000` for PHP-FPM.

## Nginx Configuration

The Nginx configuration (`nginx/default.conf`) is designed to serve the Laravel application and includes:
- **Root:** Points to the `/var/www/public` directory where Laravel’s public assets reside.
- **PHP Files:** Routes PHP files to `php-fpm` on port `9000` in the `app` container.
- **Security:** Blocks access to `.htaccess` files.

## Running Custom Commands

To run commands like `php artisan` or `composer` inside the `app` container, use the following command:

```bash
docker exec -it laravel_app bash
```

Once inside the container, you can run any Laravel or Composer command.

Example:

```bash
php artisan migrate
```

## Troubleshooting

- If you encounter any issues, check the logs of each service by running:

```bash
docker-compose logs app
docker-compose logs webserver
```

## Conclusion

This setup provides a fully containerized development environment for Laravel with Docker, leveraging `nginx` for serving the app and `php-fpm` for processing PHP requests. Feel free to modify the configuration files to suit your specific needs.

