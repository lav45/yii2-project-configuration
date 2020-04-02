<?php

if (!function_exists('config')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        if ($value = getenv($key)) {
            return $value;
        }
        return settings()->get(".{$key}", $default);
    }
}

if (!function_exists('configKey')) {
    /**
     * @return string
     */
    function configKey()
    {
        return Yii::getAlias('@app_config_key', false) ?: 'app-config';
    }
}

if (!function_exists('settings')) {
    /**
     * @return \lav45\settings\Settings|\lav45\settings\behaviors\QuickAccessBehavior
     */
    function settings()
    {
        static $model;

        if ($model !== null) {
            return $model;
        }

        $storagePath = Yii::getAlias('@app_config_path', false) ?: dirname(__DIR__) . '/storage';

        $model = new lav45\settings\Settings([
            'serializer' => false,
            'buildKey' => false,
            'keyPrefix' => configKey(),
            'storage' => [
                'class' => 'lav45\settings\storage\PhpFileStorage',
                'path' => $storagePath
            ],
            'as access' => [
                'class' => 'lav45\settings\behaviors\QuickAccessBehavior',
            ],
        ]);

        return $model;
    }
}
