<?php

ini_set("display_errors", "0");

include 'bootstrap.php';

use lib\Config;
use lib\Request;
use lib\Logger;
use lib\Bot;

$profiles = Config::get('profiles');

if (sizeof($profiles) > 0) {

    /**
     *  Авторизация в дзене и запись статистики в БД
     */

    foreach ($profiles as $item) {

        $request = new Request();
        $data = $request->send($item['login'], $item['password']);

        if ($data !== null) {
            $logger = new Logger();
            $logger->record($data);
        } else echo 'Ошибка авторизации!' . "\n";
    }

    /**
     *  Отправка статистики в телеграм бот
     */

    $bot = new Bot();
    $bot->getStats($profiles);
}