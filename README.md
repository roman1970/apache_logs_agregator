<h3><a href="https://github.com/roman1970/apache_logs_agregator">Apache_logs_aggregator</a></h3>

<p>Инструкция по установке (для тестирования и разработки):</p>

Установить Composer с  getcomposer.org , если не установлен.

В той директории, где хотите развернуть приложение выполните следующие команды:

<pre>
# клонируем репозиторий
$ git clone https://github.com/roman1970/apache_logs_agregator .

# затягиваем vendor фреймворка
$ composer install

# даём права фреймворку писать в определённые директории
$ chmod 777 web/assets
$ chmod 777 runtime

# создаём базу данных и вносим её параметры в файл настроек config/bd, который также нужно создать
# содержимое файла
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=хост_сервера_bd;dbname=имя_созданной_bd',
    'username' => 'пользователь_bd',
    'password' => 'пароль_bd',
    'charset' => 'utf8',
];

# создать файл config/params, где будут прописаны пути до логов
# содержимое файла как пример - значения вы должны вставить свои

<?php

<?php

return [
    'log_files' =>  '/var/log/nginx/access.log',
    'email_host' => '********',
    'cookieValidationKey' => '***********************',
    'mail_username' => '******',
    'mail_password' => '*******',
    'api_key' => '********'
  
];

# затем нужно применить миграции
$ php yii migrate
$ php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations

# Сбор логов можно организовать с помощью планировщика cron, например каждый час
$ crontab -e 
59 * * * * cd /путь/до/apache_logs_agregator && php yii apache-logs/logs-in-bd

</pre>

DocumentRoot вашего веб-сервера должен смотреть в /web директорию приложения

Если возникли проблемы, обращайтесь r0man4ernyshev@gmail.com или Skype roman.4ernyshev


