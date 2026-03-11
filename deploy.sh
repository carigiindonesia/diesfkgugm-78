#!/bin/bash
set -euo pipefail

DEPLOY_DIR="/opt/diesfkgugm-78"
IMAGE_TAG="${1:-latest}"

cd "$DEPLOY_DIR"

export IMAGE_TAG="$IMAGE_TAG"

# Export vars from .env that docker-compose needs for image resolution
set -a
source .env
set +a

echo "==> Pulling latest images..."
docker compose pull app worker

echo "==> Stopping worker to drain queue..."
docker compose stop worker

echo "==> Starting new app container..."
docker compose up -d --no-deps app

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

echo "==> Restarting queue worker..."
docker compose up -d --no-deps worker

echo "==> Cleaning up old images..."
docker image prune -f

echo "==> Deployment complete!"
