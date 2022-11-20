# cvsu-ees
 
STEPS----------

Run the following commands.
1. composer install -ignore-platform-req=ext-gd
2. cp .env.example .env
3. php artisan key:generate
4. php artisan migrate:fresh -seed
5. npm i
6. npm run dev
7. php artisan serve
8. npm run watch