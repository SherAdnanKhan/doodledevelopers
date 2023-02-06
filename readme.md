
**Setup the env file**
* cd src/
* cp env.dev .env

**Project Setup**

1. docker-compose up -d
2. docker exec -it red6six-api bash
3. composer install
4. php artisan migrate
5. php artisan passport:install
6. php artisan db:seed


**Api Documentation Setup**

1. php artisan docs:generate
2. http://127.0.0.1:8000/docs/


# Deployment notes

The below commands needs running on a container after a successful deployment:

php artisan migrate
php artisan db:seed
php artisan storage:link
