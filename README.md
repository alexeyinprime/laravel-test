# Тестовое задание

## Текст задания

### Laravel

* Завести новый проект.
* С помощью фабрики создать 10 пользователей.
* В контроллере отдавать список пользоватей
* для сущности User добавить поле description, в которое выводить список навыков в разных комбинациях с использованием паттерна Декоратор (реализации применять рандомно). Варианты навыков: ['php', 'js', 'golang', 'java']
* Написать тестовый метод, который проверит, что контроллером отдается список пользователей с непустым массивом навыков

### Vue/React

* Сделать список пользователей с навыками.
* Добавить форму создания нового пользователя с валидацией имени (либо только цифры не более 12 символов, либо только буквы в обоих регистрах)

Полностью рабочее приложение не нужно. Я буду смотреть на код.


### devops

* На гитхабе создать репозиторий и в файле Readme.md описать процесс деплоя сделанного приложения на компьютере, чтобы я мог его задеплоить

# Реализация

Для модели ```User``` создается через доп. миграцию и заполняется через UserSeeder текстовое поле description, со списоком Навыковов, разделенных запятой, для чего создан специальны метод возвращающий ```Attribute```.
Так же создается бонусный 11-й пользователь с именем Junior с пустым полем description

Паттерн Декоратор реализован следующим способом:
В контроллере модель User передается декорирующему классу UserWithDescription, который перегенирирует список навыков для экземляра User.

В контроллере ```UserController.php``` на 24 и 27 строках реализованы передача коллекци (```Collection```) пользователей в ```Resource``` как через User так и через декорирующий класс.

Если запускать тесты (см п 5) для каждой из реализаций то можно увидеть, что тесты не проходят в случае работы с моделью ```User``` и мы увидем ```ID``` пользователя у которого пустое поле ```description```


В контроллере 


## Установкапи

### Требования

- Тестировалось на Ubuntu 24.04 и Windows 10 с установленной и настроенной WSL 2
- Работающий docker, проверка (docker run hello-world)

### Команды процесса установки

1. Создание папки с проектом и клонированеие репозитория
```bash
mkdir PROJECT_FOLDER
cd PROJECT_FOLDER
git clone https://github.com/alexeyinprime/laravel-test.git .
```
2. Создание файла конфигурации .env в корневой папке проекта

```ini
APP_NAME=LaravelTest
APP_ENV=local
APP_KEY=base64:Jsrh0+BQaVXJpCSGeME02gwpo4zWny8nMa4HQjHeNek=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database
BCRYPT_ROUNDS=12
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug
DB_CONNECTION=sqlite
DB_DATABASE="/var/www/html/database/database.sqlite"
DB_FOREIGN_KEYS=false

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

VITE_APP_NAME="${APP_NAME}"
```
3. Выполнение установки docker образа Laravel Sail

```bash
docker run --rm     -u "$(id -u):$(id -g)"     -v "$(pwd):/var/www/html" \
    -w /var/www/html     laravelsail/php83-composer:latest  \
       composer install --ignore-platform-reqs
```
4. Запуск docker контейнера с кодом проекта и выполнение инициализации БД

```
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed UserSeeder
```
5. Тестирование

Запуск тестирования проверяет в том числе и возвращаемый через эндпроинт ```/users``` не пустые поля ```description``` у пользователей 
```bash
./vendor/bin/sail test
```


