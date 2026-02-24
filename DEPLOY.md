git pull
docker compose up -d --build
docker exec -it interno-prosecretaria-web-prod php artisan migrate --force
docker exec -it interno-prosecretaria-web-prod php artisan config:cache
docker exec -it interno-prosecretaria-web-prod php artisan route:cache || true
docker exec -it interno-prosecretaria-web-prod php artisan view:cache || true