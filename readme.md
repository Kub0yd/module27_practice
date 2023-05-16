# ПРАКТИКА (модуль 27) - Продвинутый Backend
Разработка в качестве домашнего задания курса **"Веб-разработчик"** на платформе [Skillfactory](https://skillfactory.ru/).

Тема: "Авторизация и аутентификация"

## Установка
Разработка тестировалась с использованием OpenServer

Версия тестировалась на  MySQL Community Server 8.0.30

1. Скачайте (или воспользуйтесь командой "git clone https://github.com/Kub0yd/module27_practice.git") файлы на сервер
2. Импортируйте файл [auth.sql](/auth.sql) на свой сервер MySQL
3. Для отрабоки внешних скриптов нужен доступ в интернет

## Структура
* [app](/app/) - папка со структурой фреймворка

    * [Controllers](./app/controllers/) - контроллеры проекта для каждой страницы сайта
        * [controller_auth](./app/controllers/controller_auth.php) - контроллер страницы для авторизванных пользователей
        * [controller_login.php](./app/controllers/controller_login.php) - контроллер страницы авторизации
        * [controller_main.php](./app/controllers/controller_main.php) - контроллер главной страницы 
        * [controller_registration.php](./app/controllers/controller_registration.php) - контроллер страницы регистрации
    * [core](./app/core/) - базовые файлы model, View и Controller с соответствующими классами.
        * [controller.php](./app/core/controller.php) - объявление класса controller
        * [model.php](./app/core/model.php) - объявление класса model
        * [Route.php](./app/core/route.php) - файл, отвечающий за маршрутизацию всего приложения
        * [View.php](./app/core/view.php) - объявление класса view
    * [files](./app/files/) - изображение для VK пользователя
    * [heandlers](./app/heandlers/)- обработчики проекта
        * [functions.php](./app/heandlers/functions.php)- файл с функциями
        * [rolemanger.php](./app/heandlers/rolemanager.php)- обрабочтик ролей
    * [models](./app/models/)- все модели проекта для каждой страницы сайта.
        * [model_login.php](./app/models/model_login.php) -  файл с моделью подгружаемых данных для страницы login
        * [model_registration.php](./app/models/model_registration.php) -  файл с моделью подгружаемых данных для страницы registration
    * [style](./app/style/) - папка с файлами css
    * [views](./app/views/) - все представления проекта для каждой страницы сайта.
        * [auth_view.php](./app/views/auth_view.php) - код представления страницы авторизванных пользователей
        * [login_view.php](./app/views/login_view.php) - код представления страницы авторизации
        * [main_view.php](./app/views/main_view.php) - код представления основной страницы
        * [registration_view.php](./app/views/registration_view.php) - код представления страницы регистрации
        * [template_view.php](./app/views/template_view.php) - шаблон сайта
    * [boot.php](./app/boot.php) - подгрузчик компонентов
* [vendor.php](./vendor/) - внешние компоненты
* [0auth.php](./0auth.php) - файл обработчик авторизации ВК
* [auth.sql](./auth.sql) - база данных для импорта
* [index.php](./index.php) - основной файл фреймворка
* [troubles.log](./troubles.log) - лог с информацией о неудачных попытках авторизации
