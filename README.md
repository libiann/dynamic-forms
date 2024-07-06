create database named 'dynamic_forms'
update .env file for MAIL_USERNAME and MAIL_PASSWORD
php artisan migrate:fresh --seed
php artisan serve
php artisan queue:work --queue=emails

-   Login credentials
    Admin - admin@example.com
    123456
