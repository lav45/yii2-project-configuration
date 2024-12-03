<?php

namespace lav45\projectConfiguration\console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class ConfigController
 * @package console\controllers
 */
class ConfigController extends Controller
{
    /** @var bool */
    public $force = false;

    public function options($actionID)
    {
        $options = parent::options($actionID);
        if ($actionID === 'load') {
            $options[] = 'force';
        }
        return $options;
    }

    /**
     * The universal method of access to methods `config/show`, `config/get`, `config/set`, `config/load`
     *
     * @param string|null $key
     * @param string|null $value
     */
    public function actionIndex($key = null, $value = null)
    {
        if (isset($key, $value)) {
            $this->actionSet($key, $value);
        } elseif (isset($key)) {
            if (file_exists($key)) {
                $this->actionLoad($key);
            } else {
                $this->actionGet($key);
            }
        } else {
            $this->actionShow();
        }
    }

    /**
     * Display all keys
     *
     * ~$ php yii config
     * ~> db_name: site-db
     */
    public function actionShow()
    {
        $data = settings()->get(null, []);
        foreach ($data as $key => $value) {
            $this->stdout($key, Console::FG_YELLOW);
            $value = $this->encodeValue($value);
            $this->stdout(": {$value}\n", Console::FG_GREEN);
        }
        $this->stdout("\n");
    }

    /**
     * Show value by key. Params: {key}
     *
     * ~$ php yii config/get db_name
     * ~> site-db
     *
     * @param string $key
     */
    public function actionGet($key)
    {
        $value = settings()->get(".{$key}");
        if ($value) {
            $value = $this->encodeValue($value);
            $this->stdout("{$value}\n", Console::FG_GREEN);
        }
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function encodeValue($value)
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        }
        return var_export($value, true);
    }

    /**
     * Set value by key. Params: {key} {value}
     *
     * ~$ php yii config/set db_name site-db
     *
     * @param string $key
     * @param string $value
     */
    public function actionSet($key, $value)
    {
        settings()->replace(null, $key, $value);
    }

    /**
     * Delete key. Params: {key}
     *
     * ~$ php yii config/delete db_name
     *
     * @param string $key
     */
    public function actionDelete($key)
    {
        $data = settings()->get(null, []);
        unset($data[$key]);
        settings()->set(null, $data);
    }

    /**
     * Loading data from a file config.json
     *
     * ~$ php yii config/load ../config.json
     *
     * @param string $file - path to config file in json formate
     */
    public function actionLoad($file)
    {
        $data = file_get_contents($file);
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        if ($this->force === false) {
            $data = array_merge_recursive(settings()->get(null, []), $data);
        }
        settings()->set(null, $data);
    }
}
