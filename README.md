## Порядок розгортання проекту

1. В терміналі виконати команду `git clone https://github.com/lightisthebest/binary.git`

2. Після закінчення клонування репозиторію, перейти в папку з проектом і виконати в терміналі команду `composer install`
3. Зареєструвати host для проекта на сервері
4. Створити нову пусту базу даних
5. Перейменувати файл `.env.example`на `.env` і внести адресу сайта в поле `APP_URL` (наприклад, `http://sitename.com`), інформацію про підключення до бази даних в поля `DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD`
6. В терміналі виконати команду `php artisan migrate:fresh --seed`
7. Відкрити головну сторінку сайта в браузері
