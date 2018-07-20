<?php

namespace lib;

use lib\entities\Channel;
use lib\entities\Period;
use lib\entities\Publication;

class Logger
{
    public function record($data)
    {
        $existingPubs = array();
        $updatedTime = time();
        $channel = new Channel();
        $channel->setWheres(array('=', 'login', "'" . $data['user']['login'] . "'"));

        $updateData = array(
            'channelId' => $data['userPublisher']['id'],
            'login' => $data['user']['login'],
            'name' => $data['userPublisher']['name']
        );

        $res = $channel->read()->fetch();

        if ($res !== false) {
            $channel->update($res['id'], $updateData);
            $channelId = $res['id'];
        } else {
            $channelId = $channel->create($updateData);
        }

        foreach ($data['publications'] as $publication) {
            $pub = new Publication();
            $pub->setWheres(array('=', 'pub_id', "'" . $publication['id'] . "'"));
            $existingPubs[] = '\'' . $publication['id'] . '\'';

            $updateData = array(
                'channel_id' => $channelId,
                'pub_id' => $publication['id'],
                'type' => ($publication['content']['type'] == 'article' ? 'статья' : 'нарратив'),
                'title' => str_replace("<br>",'', trim($publication['content']['preview']['title'])),
                'created_at' => round($publication['addTime'] / 1000),
                'updated_at' => round($publication['content']['modTime'] / 1000),
                'has_published' => ($publication['privateData']['hasPublished'] == 1 ? 1 : 0),
                'tags' => implode(', ', $publication['privateData']['tags'])
            );

            $res = $pub->read()->fetch();

            if ($res !== false) {
                $pub->update($res['id'], $updateData);
                $pubId = $res['id'];
            } else {
                $pubId = $pub->create($updateData);
            }

            $period = new Period();

            $updateData = array(
                'data_id' => $pubId,
                'updated_at' => $updatedTime,
                'feed_shows' => $publication['privateData']['statistics']['feedShows'],
                'shows' => $publication['privateData']['statistics']['shows'],
                'likes' => $publication['privateData']['statistics']['likes'],
                'views' => $publication['privateData']['statistics']['views'],
                'views_till_end' => $publication['privateData']['statistics']['viewsTillEnd'],
                'sum_view_time_sec' => $publication['privateData']['statistics']['sumViewTimeSec'],
                'login' => $data['user']['login']
            );

            $period->create($updateData);

        }

        if (sizeof($existingPubs) > 0) {
            $db = MysqlDriver::getConnection();
            $query = 'DELETE FROM `zen_periods` WHERE login = \'' . $data['user']['login'] . '\' AND pub_id NOT IN (' . implode(',', $existingPubs) . ')';
            $db->exec($query);
            $query = 'DELETE FROM `zen_data` zd WHERE zd.channel_id = (SELECT zc.id FROM `zen_channels` zc WHERE zc.login = \'' . $data['user']['login'] . '\') AND zd.id NOT IN (' . implode(',', $existingPubs) . ')';
            $db->exec($query);
        }


    }
}