#!/bin/bash

# .env vacío — los valores reales vienen de Railway env vars
touch .env

echo "==> PHP: $(php -v | head -1)"
echo "==> APP_URL: ${APP_URL:-<no definido>}"
echo "==> APP_KEY presente: $([ -n "$APP_KEY" ] && echo SI || echo NO)"
echo "==> DB_HOST: ${DB_HOST:-<no definido>}"

echo "==> Descubriendo paquetes..."
php artisan package:discover --ansi || true

echo "==> Limpiando caches viejos..."
php artisan config:clear  2>/dev/null || true
php artisan cache:clear   2>/dev/null || true
php artisan route:clear   2>/dev/null || true
php artisan view:clear    2>/dev/null || true

echo "==> Corriendo migraciones..."
php artisan migrate --force || echo "WARN: migraciones fallaron, revisa DB_*"

echo "==> Storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "==> Cacheando configuracion..."
php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true

echo "==> Iniciando servidor en puerto ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
