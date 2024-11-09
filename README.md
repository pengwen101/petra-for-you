# Petra For You
## Setup
```bash
copy .env.example .env # change your database setup
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed # if not present already
php artisan serve
npm run dev
```