docker-compose up -d
docker exec transactionapp-php composer install --no-dev
docker exec transactionapp-php cp .env.example .env
docker exec transactionapp-php php artisan key:generate
docker exec transactionapp-php php artisan migrate --seed --force
docker exec transactionapp-php php artisan config:cache
