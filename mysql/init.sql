CREATE USER 'laravel_user'@'%' IDENTIFIED BY 'laravel_pass';
GRANT ALL PRIVILEGES ON transaction_app.* TO 'laravel_user'@'%' WITH GRANT OPTION;
flush privileges;
