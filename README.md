## About The Application

The application accesses the Hacker News API (stories, comments, best stories) and store them in the database

## How to Install 

Clone the project <br />
Install npm and composer update <br />
Duplicate the file .env_example to .env and change the 
database connections on the following <br /><br />
```DB_CONNECTION=mysql```<br />
```DB_HOST=127.0.0.1```<br />
```DB_PORT=3306```<br />
```DB_DATABASE=hacker_news```<br />
```DB_USERNAME=root```<br />
```DB_PASSWORD=```<br />

Run Migration with the following Command <br /><br />
```php artisan migrate```

Generate the key for the application

```key generate```

Start the server with

``php artisan serve``
## Developer

Wandumi Munandi Sichali <br />
Full Stack Developer 

