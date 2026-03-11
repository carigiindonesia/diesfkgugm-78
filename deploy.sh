#!/bin/bash
set -euo pipefail

DEPLOY_DIR="/opt/diesfkgugm-78"
IMAGE_TAG="${1:-latest}"

cd "$DEPLOY_DIR"

export IMAGE_TAG="$IMAGE_TAG"

# Export IMAGE_NAME from .env for docker-compose image resolution
export IMAGE_NAME=$(grep '^IMAGE_NAME=' .env | cut -d'=' -f2)

echo "==> Verifying .env..."
echo "DB_HOST=$(grep '^DB_HOST=' .env | cut -d'=' -f2)"
echo "IMAGE_NAME=$IMAGE_NAME"

echo "==> Pulling latest images..."
docker compose pull app worker

echo "==> Stopping worker..."
docker compose stop worker 2>/dev/null || true

echo "==> Starting mysql and app..."
docker compose up -d mysql app

echo "==> Waiting for MySQL to accept connections..."
timeout 120 bash -c 'until docker compose exec mysql mysqladmin ping -h localhost --silent 2>/dev/null; do sleep 3; done'
# Extra wait for MySQL to be fully ready for TCP connections
sleep 5

echo "==> Waiting for app to be ready..."
timeout 60 bash -c 'until docker compose exec app curl -sf http://localhost:8081/up > /dev/null 2>&1; do sleep 2; done'

echo "==> Running migrations..."
docker compose exec app php artisan migrate --force

echo "==> Clearing and warming caches..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan event:cache
docker compose exec app php artisan icons:cache
docker compose exec app php artisan filament:cache-components

echo "==> Ensuring storage link..."
docker compose exec app php artisan storage:link --force 2>/dev/null || true

echo "==> Starting worker..."
docker compose up -d worker

echo "==> Cleaning up old images..."
docker image prune -f

echo "==> Deployment complete!"
