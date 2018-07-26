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

    public function readPubs($channelId, $data)
    {
        $db = MysqlDriver::getConnection();
        $query = 'select zd.created_at, zd.title,
                  (select MAX(zp.feed_shows) from `zen_periods` zp WHERE zp.data_id = zd.id) as feed_shows,
                  (select MAX(zp.views) from `zen_periods` zp WHERE zp.data_id = zd.id) as views,
                  (select MAX(zp.views_till_end) from `zen_periods` zp WHERE zp.data_id = zd.id) as views_till_end 
                  from `zen_data` zd
                  join `zen_channels` zc on zc.id = zd.channel_id                    
                  where zc.channelId = \''. $channelId .'\'
                  and zd.has_published = 1
                  and DATE_FORMAT(FROM_UNIXTIME(zd.created_at), \'%Y-%m-%d\') IN ('. implode(',', $data) . ')';

        return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}