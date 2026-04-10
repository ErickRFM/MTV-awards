#!/bin/sh
set -e

echo "Iniciando MTV Awards..."

php /var/www/html/scripts/sync_upload_assets.php
UPLOAD_DIR="$(php -r '$config = require "/var/www/html/config/config.php"; echo $config["app"]["upload_dir"];')"

mkdir -p "$UPLOAD_DIR"
chown -R www-data:www-data "$UPLOAD_DIR"
chmod -R u+rwX,g+rwX "$UPLOAD_DIR"

if [ -L /var/www/html/public/uploads ]; then
  chown -h www-data:www-data /var/www/html/public/uploads || true
fi

echo "Assets visuales sincronizados en $UPLOAD_DIR."

ATTEMPTS=0
MAX_ATTEMPTS="${MIGRATION_ATTEMPTS:-10}"
SLEEP_SECONDS="${MIGRATION_SLEEP_SECONDS:-5}"

while [ "$ATTEMPTS" -lt "$MAX_ATTEMPTS" ]; do
  if php /var/www/html/database/migrate.php; then
    echo "Migraciones listas."
    break
  fi

  ATTEMPTS=$((ATTEMPTS + 1))
  echo "No fue posible conectar con MySQL. Reintentando en ${SLEEP_SECONDS}s (${ATTEMPTS}/${MAX_ATTEMPTS})..."
  sleep "$SLEEP_SECONDS"
done

if [ "$ATTEMPTS" -ge "$MAX_ATTEMPTS" ]; then
  echo "No se pudo preparar la base de datos despues de varios intentos."
  exit 1
fi

exec apache2-foreground
