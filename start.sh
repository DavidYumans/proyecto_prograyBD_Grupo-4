#!/bin/bash
echo "==> pwd: $(pwd)"
echo "==> php: $(php -v 2>&1 | head -1)"
echo "==> PORT: ${PORT:-<vacío>}"
echo "==> APP_KEY: $([ -n "$APP_KEY" ] && echo SET || echo 'NO CONFIGURADO')"
echo "==> APP_URL: ${APP_URL:-<vacío>}"
echo "==> DB_HOST: ${DB_HOST:-<vacío>}"

touch .env

echo "==> Migraciones..."
php artisan migrate --force 2>&1 || echo "WARN: migrate falló"

echo "==> Storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "==> Optimizando..."
php artisan optimize 2>&1 || echo "WARN: optimize falló"

echo "==> Iniciando servidor en puerto ${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
