installation:
first:
    read this page and do the instructions:
    https://devmarketer.io/learn/setup-laravel-project-cloned-github-com
second:
    install passport on application:  php artisan passport:install
3th:
    config your database in .env file
4th:
    migrate the application except books table and rating table
5th:
    migrate the book and rating table
6th:
    to fill your database with test data,run :    php artisan db:seed
7th:
    create a personal client by using:    php artisan passport:client --personal

    
