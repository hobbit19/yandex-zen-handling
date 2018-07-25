<?php

namespace lib;

use lib\commands\Runnable;
use lib\entities\Command;

class CommandManager
{
    public static function process($result)
    {
        $currentCommand = self::_checkCommand($result['message']['text']);

        if ($currentCommand !== false) {
            $message = new Command();
            $message->setWheres(array('=', 'messageId', "'" . $result['message']['message_id'] . "'"));
            $res = $message->read();

            if ($res === false) {

                $data = array(
                    'messageId' => $result['message']['message_id'],
                    'date' => $result['message']['date'],
                    'text' => $result['message']['text']
                );

                $messageId = $message->create($data);
            }

            if (isset($messageId))
                $currentCommand->run();
        }

    }

    private static function _checkCommand($command)
    {
        $commandClass = ucfirst(str_replace('/', '', $command));

        if (class_exists('lib\\commands\\' . $commandClass)) {

            $fullCommandClass = 'lib\\commands\\' . $commandClass;
            $commandObj = new $fullCommandClass;

            if ($commandObj instanceof Runnable)
                return $commandObj;
        }

        return false;
    }
}