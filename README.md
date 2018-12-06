Персональные финансы (Домашняя бухгалтерия на Yii2)
================================

## Главное окно приложения
![alt tag](https://github.com/TimurMelnikov/yii2-perfi/blob/master/my_files/images/main.png)

## Управление расходами
![alt tag](https://github.com/TimurMelnikov/yii2-perfi/blob/master/my_files/images/expense.png)

## Управление пользователями
![alt tag](https://github.com/TimurMelnikov/yii2-perfi/blob/master/my_files/images/user.png)

## На мобильном устройстве
![alt tag](https://github.com/TimurMelnikov/yii2-perfi/blob/master/my_files/images/mobile.jpg)

## Приложение на стадии разработки и в данный момент НЕ РАБОТОСПОСОБНО! Пишу для себя, когда есть время и вдохновение...

## В планах: 

Разработка WEB приложения для учета фнансов семьи, с возможностью работы как с компьютера, так и с мобильного устройства.

## Для установки:

Перед установкой, должен быть предварительно установлен и настроен Composer.

1. Поместить папку perfi в корневую папку WEB сервера. Например, для XAMPP под Windows - в C:\xampp\htdocs, должно получиться так - C:\xampp\htdocs\perfi

2. Создать базу данных MySQL и накатить на нее дамп perfi.sql, который находится в папке C:\xampp\htdocs\perfi\my_files\sql

3. Настроить в конфигурационном файле приложения C:\xampp\htdocs\perfi\config\db.php соединение с базой данных

4. Для установки Yii фреймворка и компонентов - выполнить команду composer update.
