yii2-project-configuration
==========================

[![Latest Stable Version](https://poser.pugx.org/lav45/yii2-project-configuration/v/stable)](https://packagist.org/packages/lav45/yii2-project-configuration)
[![License](https://poser.pugx.org/lav45/yii2-project-configuration/license)](https://packagist.org/packages/lav45/yii2-project-configuration)
[![Total Downloads](https://poser.pugx.org/lav45/yii2-project-configuration/downloads)](https://packagist.org/packages/lav45/yii2-project-configuration)

This extension helps you to easily store and retrieve settings for your project.

## Installation

The preferred way to install this extension through [composer](http://getcomposer.org/download/).

You can set the console

```
~$ composer require "lav45/yii2-project-configuration" --prefer-dist
```

or add

```
"require": {
    "lav45/yii2-project-configuration": "1.0.*"
}
```

in ```require``` section in `composer.json` file.


## Using

```php
// Yii::setAlias('@app_config_path', __DIR__ . '/settings');

$db_name = config('db_name', 'site-db-name');
$db_host = config('db_host', 'localhost');

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "mysql:host={$db_host};dbname={$db_name}",
            'username' => config('db_username', 'root'),
            'password' => config('db_password', '****'),
            'enableSchemaCache' => true,
            'charset' => 'utf8',
        ],
    ]
];
```


## Management

Control is made through a console controller
Will add it to the console application's configuration file

```php
return [
    'controllerMap' => [
        'config' => 'lav45\projectConfiguration\console\controllers\ConfigController'
    ]
];
```

### Use console controller

```
# Set value by key
~$ php yii config/set db_name site-db

# Display all keys
~$ php yii config
~>    db_name: site-db

# or Show value by key
~$ php yii config/get db_name
~> site-db

# Delete key
~$ php yii config/delete db_name
```


You can configure the component using [Yii::setAlias()](https://github.com/yiisoft/yii2/blob/2.0.12/docs/guide/concept-aliases.md#defining-aliases-) before using the `config()`

| Key              | Default value                 | Description                                          |
|:-----------------|:------------------------------|:-----------------------------------------------------|
| @app_config_key  | 'app-config'                  | The key which will be stored settings                |
| @app_config_path | '/storage'                    | Path where will be stored the file with the settings |

## License

**yii2-project-configuration** it is available under a BSD 3-Clause License. Detailed information can be found in the `LICENSE.md`.
