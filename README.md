## Конвертер валюты с авторизацией

авторизация через логин/пароль; 
конвертер валюты в рубли и из рублей по курсу с сайта cbr.ru

## Установка

php 7.4+; mysql (mysql_pdo); composer

```
git clone
```

замените в config/database.php пароль и пользователя

```
php composer.phar run-script migrate
```

тестовый сервер  ```php -S localhost:8000 -t public/```

добавить задачу в crontab (для обновления курса валют каждые 3 часа; на сайте cbr.ru курс обновляется раз в день или выставляется последний известный курс в случае выходных)

```
sudo crontab -e
 * * * * * curl localhost:8000/curl_currencies
```

