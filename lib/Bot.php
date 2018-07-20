<?php

namespace lib;

class Bot
{
    private $_config;

    public function __construct()
    {
        $this->_config = Config::get('bot');
    }

    public function getStats($profiles)
    {
        if ($this->_config['active'] != 1)
            return;

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
            'chat_id' => $this->_config['chat_id'],
            'text' => $message
        );

        if ($ch = curl_init()) {
            curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $this->_config['token'] . '/sendMessage');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

            if ($this->_config['use_ssl'] == 0) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }

            // использовать прокси
            if ($this->_config['use_proxy'] == 1) {

                curl_setopt($ch, CURLOPT_PROXY, $this->_config['proxy_url']);

                if (isset($this->_config['proxy_pass']) && !empty($this->_config['proxy_pass']))
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->_config['proxy_password']);
            }

            $resp = curl_exec($ch);

            if ($resp === false) {
                echo 'Error while sending message: ' . curl_error($ch);
            }

            curl_close($ch);

        } else die('Error curl');

    }
}