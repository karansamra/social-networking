# Social Networking Sample

A social networking demo. Includes 
```
Login 
Registration 
Registration and Login using Facebook 
Posting content 
Real Time Push notification to the followers for newly posted content
Details page of the Post
List of users
Follow the user
```

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
PHP >= 7.1.3
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
XML PHP Extension
Ctype PHP Extension
JSON PHP Extension
```

### Installing

#### For Facebook Login you need to install the certificate
```
ssl certificate/cacert.pem
```
Here:
```
D:\wamp64\bin\php\php7.1.9\extras\ssl
```

#### To install all the PHP packages and Frontend Packages you need to run:
```
composer install
npm install
```


#### You should make a virtual host on your system with, the name could social-networking.example
Entry in apache vhosts file
```
<VirtualHost 127.0.0.3:80>
	ServerName socialnetworking.example
	DocumentRoot "d:/wamp64/www/social-networking/public"
	<Directory  "d:/wamp64/www/social-networking/public/">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require local
	</Directory>
</VirtualHost>
```
Dont forget to update host file on windows.

#### The public disk is intended for files that are going to be publicly accessible. By default, the  public disk uses the local driver and stores these files in storage/app/public. To make them accessible from the web, you should create a symbolic link from public/storage to  storage/app/public. This convention will keep your publicly accessible files in one directory that can be easily shared across deployments when using zero down-time deployment systems like Envoyer.

To create the symbolic link, you may use the storage:link Artisan command:
```
php artisan storage:link
```


#### change the env.example file to .env

#### Run database migrations, this will provide you fresh and empty database.

```
php artisan migrate
```


## Deployment

Following commands helps during development:
```
composer dump-autoload
npm watch
```

## Built With

* PHP 7.1.9
* Laravel 5.6
* Javascript
* NPM
* Composer
* Eloquent
* Blade
* MySQL server 5.7.19
* Apache 2.4
* Pusher


## Authors

* **Jaskaran Singh** - *Initial work* - [iLook](www.ilook.com)

## Screenshots

* See https://github.com/karansamra/social-networking/tree/master/screenshots

