docker-compose up -d
docker exec transactionapp-app composer install
docker exec transactionapp-app cp .env.example .env
docker exec transactionapp-app php artisan key:generate --force
docker exec transactionapp-app php artisan config:cache
docker exec transactionapp-app php artisan migrate --seed --force
