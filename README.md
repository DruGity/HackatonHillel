# HackatonHillel
This is test task for hackaton


Запуск сервера ``bin/console server:run``

Поднятие базы:


1.Вариант:


Создать базу с помощью файла - hackaton.sql, который уже имеет тестовые данные и находиться в корне репозитория.


2.Вариант:


1.Создать базу данных с определенным названием, после чего ввести комманду ``bin/console doctrine:schema:update --force``


После чего будет необходимо вводить тестовые данные


#При обоих вариантах в файле .env необходимо сконфигурировать ``DATABASE_URL`` на 27 строке.


``DATABASE_URL=mysql://root:DBpassword@DBhost:DBport/DBname``



PS: сообщение при 204 статусе выводиться не будет, так как 204 код - No Content
