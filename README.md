<h3><a href="https://github.com/roman1970/apache_logs_agregator">Apache_logs_agregator</a></h3>

<p>Инструкция по установке и эксплуатации:</p>

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
# содержимое файла как пример

return [
    'log_files' => [
        'apache' => '/var/log/apache2/access.log',
        //'nginx' => '/var/log/nginx/access.log'
    ]
];

# затем нужно применить миграции
$ php yii migrate
$ php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations

</pre>

