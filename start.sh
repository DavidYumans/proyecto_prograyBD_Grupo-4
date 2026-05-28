#!/bin/bash
set -e

# Laravel necesita un .env aunque sea vacío (los valores reales vienen de Railway)
touch .env

# Migraciones
php artisan migrate --force

# Enlace de storage
php artisan storage:link --force 2>/dev/null || true

# Cache para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Servidor
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
