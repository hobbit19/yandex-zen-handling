<?php

namespace lib;

include('simple_html_dom.php');

class Request
{
    private $_url = 'https://passport.yandex.ru/auth?retpath=https%3A%2F%2Fzen.yandex.ru%2Fmedia%2Fzen%2Flogin';

    public function send($login, $password, $getContext = false)
    {
        $html = file_get_html($this->_url, false, null, 0);
        $str = $text = '';

        foreach($html->find('form input') as $e) {
            $name = $e->getAttribute('name');
            $val = $e->getAttribute('value');

            if ($name == 'login') {
                $str .= '&login=' . $login;
            } elseif ($name == 'passwd') {
                $str .= '&passwd=' . $password;
            } else $str .= '&' . $name . '=' . $val;
        }

        // autorization

        $cookies = file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'cookies.txt') ? true : false;

        if ($ch = curl_init()) {
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $str);

            if ((version_compare(PHP_VERSION, '5.5') >= 0)) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
            }

            if ($cookies) {
                curl_setopt($ch, CURLOPT_COOKIEFILE,   __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'cookies.txt');
            } else {
                curl_setopt($ch, CURLOPT_COOKIEJAR,  __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . 'cookies.txt');
            }

            $response = curl_exec($ch);

            $html = str_get_html($response);

            foreach($html->find('textarea#init_data') as $e)
                $text = htmlspecialchars_decode(trim($e->innertext));

            $result = json_decode($text, true);

            if ($getContext)
                return array(
                    'ch' => $ch,
                    'userPublisher' => $result['userPublisher']['id']
                );

            curl_close($ch);

            return $result;

        } else die('Curl error!');
    }

    public function getKarma($login, $password)
    {
        $result = $this->send($login, $password, true);
        $ch = $result['ch'];

        curl_setopt($ch, CURLOPT_URL, 'https://zen.yandex.ru/profile/editor/id/' . $result['userPublisher'] . '/karma');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        $html = str_get_html($response);

        foreach($html->find('textarea#csrfToken') as $e)
            $text = htmlspecialchars_decode(trim($e->innertext));

        curl_setopt($ch, CURLOPT_URL, 'https://zen.yandex.ru/media-api/get-user-karma?publisherId=' . $result['userPublisher']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Csrf-Token' => $text));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        var_dump($response);


    }
}