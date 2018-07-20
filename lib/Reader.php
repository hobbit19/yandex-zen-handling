<?php

namespace lib;

use PDO;

class Reader
{
    public function read($login)
    {
        $db = MysqlDriver::getConnection();
        $query = 'select DATE_FORMAT(FROM_UNIXTIME(zp.updated_at), \'%Y-%m-%d %H:%m\') as date_formatted, SUM(zp.feed_shows) as fs, SUM(zp.shows) as s, SUM(zp.likes) as l, SUM(zp.views) as v, SUM(zp.views_till_end) as vte, SUM(zp.sum_view_time_sec) as svts, zc.channelId 
                  from `zen_periods` zp
                  join `zen_channels` zc on zc.login = zp.login 
                  where zp.login = \''. $login .'\'
                  and updated_at >= UNIX_TIMESTAMP() - 3600 * 24 * 7
                  group by date_formatted, zc.channelId';

        return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}