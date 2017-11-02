<?php

if (!function_exists('config')) {
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        static $data;

        if ($data === null) {
            $data = settings()->get(configKey(), []);
        }

        return getenv($key) ?: (isset($data[$key]) || array_key_exists($key, $data) ? $data[$key] : $default);
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
     * @return \lav45\settings\Settings
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
            'storage' => [
                'class' => 'lav45\settings\storage\PhpFileStorage',
                'path' => $storagePath
            ],
        ]);

        return $model;
    }
}
