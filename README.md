# SuperWebForms
This is the source code for [https://superwebforms.infinityfreeapp.com](https://superwebforms.infinityfreeapp.com).

This web application is in continuous development.


## Dependencies
Super WebForms depends on the following libraries.
- [patreon-php](https://github.com/Patreon/patreon-php)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [google-api-php-client](https://github.com/googleapis/google-api-php-client)

The preferred method is via [composer](https://getcomposer.org/). Follow the [installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have composer installed.
Example of a composer installation command for debian-based distributions:
```
sudo apt-get update
sudo apt-get install composer
```
Example of a composer installation command for CentOS/RHEL/Fedora distributions:
```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```
Once composer is installed, execute the following commands in your project root to install these libraries:
```
composer require patreon/patreon
composer require phpmailer/phpmailer
composer require google/apiclient:"^2.7"
```

## Instalation
All custom configurations are found in config.php.
First transfer all the code to the site folder. Standard Apache path:
```
/var/www/html
```

Edit all custom configurations are found in config.php.
Reload the host service. Apache exemple:
```
sudo systemctl restart apache2
sudo systemctl reload apache2
```
