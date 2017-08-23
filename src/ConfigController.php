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
    /**
     * Display all keys
     *
     * ~$ php yii config
     * ~> db_name: site-db
     */
    public function actionIndex()
    {
        foreach ($this->get() as $key => $value) {
            $this->stdout("  {$key}", Console::FG_YELLOW);
            if (is_string($value)) {
                $this->stdout(": {$value}", Console::FG_GREEN);
            }
            $this->stdout("\n");
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
        $data = $this->get();
        if (isset($data[$key])) {
            echo $data[$key] . "\n";
        }
    }

    /**
     * Set value by key. Params: {key} {value}
     * 
     * ~$ php yii config/set db_name site-db
     * 
     * @param string $key
     * @param $value
     */
    public function actionSet($key, $value)
    {
        $data = $this->get();
        $data[$key] = $value;
        $this->set($data);
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
        $data = $this->get();
        unset($data[$key]);
        $this->set($data);
    }

    /**
     * @return array
     */
    private function get()
    {
        return settings()->get(configKey(), []);
    }

    /**
     * @param array $values
     */
    private function set($values)
    {
        settings()->set(configKey(), $values);
    }
}