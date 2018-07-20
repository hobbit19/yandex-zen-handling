<?php

namespace lib;

class DataGetter
{
    public static function get($login)
    {
        $reader = new Reader();

        $data = $reader->read($login);

        $tmp = array();

        $size = sizeof($data);

        if ($size > 0) {

            $prevFs = 0;
            $prevV = 0;
            $prevVte = 0;
            $totalFs = 0;
            $totalViews = 0;
            $totalViewsTillEnd = 0;

            foreach ($data as $k => $item) {

                $date = substr($item['date_formatted'], 0, 10);

                if (isset($data[$k-1]) && $date != substr($data[$k-1]['date_formatted'], 0, 10)) {
                    $tmp['fs'][] = array(
                        strtotime($item['date_formatted']) * 1000,
                        $item['fs']
                    );
                    $tmp['v'][] = array(
                        strtotime($item['date_formatted']) * 1000,
                        $item['v']
                    );
                    $tmp['vte'][] = array(
                        strtotime($item['date_formatted']) * 1000,
                        $item['vte']
                    );
                }

                if ($k == $size - 1) {

                    $fsPercent = ($prevFs - 100) > 0 ? round($item['fs'] * 100 / $prevFs - 100, 2) : 0;
                    $vPercent = ($prevV - 100) > 0 ? round($item['v'] * 100 / $prevV - 100, 2) : 0;
                    $vtePercent = ($prevVte - 100) > 0 ? round($item['vte'] * 100 / $prevVte - 100, 2) : 0;

                    $tmp['last']['fs'] = $item['fs'] . ' (' . ($item['fs'] - $prevFs) . ', ' . $fsPercent . '%)';
                    $tmp['last']['v'] = $item['v'] . ' (' . ($item['v'] - $prevV)  . ', ' . $vPercent . '%)';
                    $tmp['last']['vte'] = $item['vte'] . ' (' . ($item['vte'] - $prevVte)  . ', ' . $vtePercent . '%)';

                } elseif ($k == $size - 2) {

                    $prevFs = $item['fs'];
                    $prevV = $item['v'];
                    $prevVte = $item['vte'];

                }

                $totalFs += $item['fs'];
                $totalViews += $item['v'];
                $totalViewsTillEnd += $item['vte'];
            }

            $tmp['interest'] = ($totalFs > 0 ? round($totalViews * 100 / $totalFs, 2) : 0) . '%';
            $tmp['quality'] = ($totalViews > 0 ? round($totalViewsTillEnd * 100 / $totalViews, 2) : 0) . '%';
            $tmp['forecast'] = self::_getForecast($data);
            $tmp['channelId'] = $data[0]['channelId'];

        }


        return $tmp;
    }

    private static function _getForecast($data)
    {
        $config = Config::get('config');

        if ($config['show_goal_count'] === false)
            return '-';

        $maxCount = sizeof($data) - 1;
        $first = $data[$maxCount]['vte'];
        $yesturdayDate = substr($data[$maxCount]['date_formatted'], 0, 10);
        $yesturday = date("Y-m-d", strtotime( '-1 days', strtotime($yesturdayDate)));

        foreach ($data as $k => $item) {
            if (substr($item['date_formatted'], 0, 14) == $yesturday . ' 00:') {
                $second = $item['vte'];
                break;
            }
        }

        $diff = $first - $second;

        if ($diff <= 0)
            return '-';


        return round(($config['goal'] - $first) / $diff, 2) . ' дн до ' . $config['goal'] . ' дочитываний (' . $diff . ' в день)';
    }
}