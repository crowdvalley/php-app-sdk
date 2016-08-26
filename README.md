# php-app-sdk
============

Full SDK for implementing the Crowd Valley API in your PHP application

### Installation using Composer

1) If you don't have Composer yet, download it following the instructions on `http://getcomposer.org/` or just run the following command:

```
curl -s http://getcomposer.org/installer | php

php composer.phar install
```

2) Add the following to the "require" section of your `composer.json` file:

```
{
    "require": {
        "crowdvalley/php-app-sdk": "*"
    }
}
```

3) Finally, you can run:

```
composer install
```

The files will be downloaded and by default placed into a `vendors` folder within the root of your application.

4) Depending on the framework you wish to use, you may need to follow further instructions to implement the 'autoload' function. 

For example, in Symfony projects, you would add the following line to your `~/app/AppKernel.php` file:

```
new CrowdValley\Bundle\ClientBundle\CrowdValleyClientBundle(),
```

For any queries or comments on the installation process, please contact support@crowdvalley.freshdesk.com.

