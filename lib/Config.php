<?php

namespace lib;

class Config
{
    public static function get($config = null)
    {
        $configArr = array();
        $configDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config';
        $content = scandir($configDir);

        foreach ($content as $item) {
            if (!in_array($item, array('.', '..'))) {
                $name = explode('.', $item);
                $configArr[$name[0]] = include $configDir . DIRECTORY_SEPARATOR . $item;
            }
        }

        return !is_null($config) && isset($configArr[$config]) ? $configArr[$config] : $configArr;
    }
}