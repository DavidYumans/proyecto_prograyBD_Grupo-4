#!/bin/bash

# .env vacío para que Laravel no falle al iniciar
touch .env

# Migraciones — si fallan, continuamos igual
php artisan migrate --force || true

# Storage link
php artisan storage:link --force 2>/dev/null || true

# Cache de producción — ignorar errores
php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true

# Servidor en el puerto que Railway asigna
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
