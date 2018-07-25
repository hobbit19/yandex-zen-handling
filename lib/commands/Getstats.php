<?php

namespace lib\commands;

use lib\Config;
use lib\DataGetter;

class Getstats implements Runnable
{
    public function run()
    {
        $config = Config::get('bot');

        if ($config['active'] != 1)
            return;

        $profiles = Config::get('profiles');
        $message = '';

        foreach ($profiles as $item) {
            $data = DataGetter::get($item['login']);
            $message .= 'Канал: ' . $item['login'] . "\n";
            $message .= 'Ссылка: ' . 'https://zen.yandex.ru/id/' . $data['channelId'] . "\n";
            $message .= 'Лента: ' . $data['last']['fs'] . "\n";
            $message .= 'Просмотры: ' . $data['last']['v'] . "\n";
            $message .= 'Дочитывания: ' . $data['last']['vte'] . "\n";
            $message .= 'Качество: ' . $data['quality'] . "\n";
            $message .= 'Интерес: ' . $data['interest'] . "\n";
            $message .= 'Прогноз: ' . $data['forecast'] . "\n\n";
        }

        $params = array(
            'chat_id' => $config['chat_id'],
            'text' => $message
        );

        if ($ch = curl_init()) {
            curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $config['token'] . '/sendMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            if ($config['use_ssl'] == 0) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            // использовать прокси
            if ($config['use_proxy'] == 1) {

                curl_setopt($ch, CURLOPT_PROXY, $config['proxy_url']);

                if (isset($config['proxy_pass']) && !empty($config['proxy_pass']))
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $config['proxy_password']);
            }

            $resp = curl_exec($ch);

            if ($resp === false) {
                echo 'Error while sending message: ' . curl_error($ch);
            }

            curl_close($ch);

        } else die('Error curl');
    }
}