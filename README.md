composer install

copy .env.example and rename to .env

setup database in .env

setup url to project in .env

php artisan migrate

npm install

npm run dev

Добавить url для спарсивания, можно на главной странице.
Спарсивание xml файлов (создание/обновление) осуществялется в app/Jobs/xmlHandlerJob.php
Переодическое обновление в app/Console/Kernel.php
Эндпоинты (rest api) app/Http/Controllers/OffersController.php
