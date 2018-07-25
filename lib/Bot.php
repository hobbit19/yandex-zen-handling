<?php

namespace lib;

class Bot
{
    private $_config;

    public function __construct()
    {
        $this->_config = Config::get('bot');
    }

    public function runCommands()
    {
        $res = file_get_contents('https://api.telegram.org/bot' . $this->_config['token'] . '/getUpdates');
        $data = json_decode($res, true);

        if (isset($data['ok']) && $data['ok'] == 1) {
            foreach ($data['result'] as $result) {
                if (isset($result['message']['entities']) && $result['message']['entities'][0]['type'] == 'bot_command') {
                    CommandManager::process($result);
                }
            }
        }
    }
}