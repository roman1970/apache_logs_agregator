Apache_logs_agregator

Инструкция по установке и эксплуатации:

Установить Composer с  getcomposer.org , если не установлен.



For Apache:

<VirtualHost *:80>
    ServerName www.yii2-start.domain # You need to change it to your own domain  
    ServerAlias yii2-start.domain # You need to change it to your own domain  
    DocumentRoot /my/path/to/yii2-start # You need to change it to your own path  
    <Directory /my/path/to/yii2-start> # You need to change it to your own path  
        AllowOverride All  
    </Directory>  
</VirtualHost>
Use the URL http://yii2-start.domain to access application frontend.
Use the URL http://yii2-start.domain/backend/ to access application backend.
