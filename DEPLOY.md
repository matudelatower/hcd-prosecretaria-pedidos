git pull
docker compose up -d --build
docker exec -it interno-prosecretaria-internas-prod php artisan migrate --force
docker exec -it interno-prosecretaria-internas-prod php artisan config:cache
docker exec -it interno-prosecretaria-internas-prod php artisan route:cache || true
docker exec -it interno-prosecretaria-internas-prod php artisan view:cache || true