# Тестовое задание

## Инструкции по развертыванию

1. cd /data/datainlife/
2. Клонируйте репозиторий: `git clone git@github.com:DjulianMentl/laravel_test.git`
3. Откройте терминал и выполните `cd /data/datainlife/laravel_test/infra`
4. Выполните команду: `docker-compose up -d --build`
5. Войти в Docker-контейнер: `docker-compose exec php-service bash`
6. Выполнить команду `composer install`
7. Применить миграции `cd /var/www/html/test-app && php artisan migrate `  

## Задание
Необходимо реализовать бэкенд веб-приложения. Все данные должны храниться в базе данных.
В качестве результата выполнения задания предоставить ссылку на git-репозиторий.

## Требования
- использование PHP версии 8+
- использование фреймворка Laravel версии 10+

## Миграции:
    ▪ users
        ▪ id - автоинкремент
        ▪ name
        ▪ email
        ▪ active (по-умолчанию true)
    ▪ groups
        ▪ id - автоинкремент
        ▪ name
        ▪ expire_hours с комментарием «через какое количество часов пользователь после добавления в группу должен быть исключен из группы»
    ▪ group_user
        ▪ user_id – внешний ключ на пользователя
        ▪ group_id – внешний ключ на группу
        ▪ expired_at – datetime
        ▪ обеспечить уникальность пары user_id <-> group_id
## Сидеры:
    ◦ groups
        ▪ [name: Группа1, expire_hours: 1]
        ▪ [name: Группа2, expire_hours: 2]
    ◦ users
        ▪ [name: Иванов, email: info@datainlife.ru]
        ▪ [name: Петров, email: job@datainlife.ru]
## REST API:
    ◦ Методы создания и редактирования пользователей, групп. Обеспечить валидацию вводимых данных.
    ◦ Метод получения группы. Объект группы должен содержать список пользователей, входящих в группу.
    ◦ Метод получения пользователя. Объект пользователя должен содержать перечень групп, в которых состоит пользователей
## Обсервер:
    ◦ При добавлении пользователя в группу автоматически заполнить поле expired_at, равным количеству часов, указанному в expire_hours у группы, в которую добавляется пользователь.
## Разработать консольные команды:
    ▪ php artisan user:member
        ▪ запросить user_id пользователя
        ▪ запросить group_id группы
        ▪ добавить пользователя user_id в группу group_id, если пользователь не активен (active == false), активировать его (active = true)
    ▪ php artisan user:check_expiration
        ▪ всех пользователей исключить из групп, у которых expired_at меньше текущего момента времени
        ▪ дополнительно – по факту исключения пользователя из группы выслать email пользователю: Здравствуйте name! Истекло время вашего участия в группе {name}.
        ▪ приветствуется – по факту исключения пользователя из группы поставить в очередь задачу: если пользователь не входит ни в одну группу, деактивировать его (установить у пользователя active = false).
## cron
    • Добавить команду user: check_expiration в расписание на выполнение раз в 10 минут

