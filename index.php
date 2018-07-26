<?php

ini_set("display_errors", "0");

include 'bootstrap.php';

use lib\Config;

$profiles = Config::get('profiles');

/**
 *  Отображение статистики на графике
 */

?>
<!DOCTYPE html>
<html lang="ru" >
    <head>
        <meta charset="UTF-8">
        <title>Статистика</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/highcharts.js"></script>
        <script src="js/exporting.js"></script>
        <script src="js/export-data.js"></script>

    </head>
    <body>

    <div id="profiles">
        <ul style="display: inline">
            <?php
            foreach ($profiles as $item) {
                echo '<li><input type="radio" name="login" value="' . $item['login'] . '"> ' . $item['login'] . '</li>';
            }
            ?>
        </ul>

    </div>

    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script src="js/index.js"></script>

    <div>
        <table border="1">
            <tr>
                <th>Лента</th>
                <td><div id="lastFs"></div></td>
            </tr>
            <tr>
                <th>Просмотры</th>
                <td><div id="lastV"></div></td>
            </tr>
            <tr>
                <th>Дочитывания</th>
                <td><div id="lastVte"></div></td>
            </tr>
            <tr>
                <th>Качество</th>
                <td><div id="quality"></div></td>
            </tr>
            <tr>
                <th>Интерес</th>
                <td><div id="interest"></div></td>
            </tr>
            <tr>
                <th>Прогноз</th>
                <td><div id="forecast"></div></td>
            </tr>
            <tr>
                <th>Публикации за неделю</th>
                <td>
                    <div class="pubDiv">
                        <div><strong>Название</strong></div>
                        <div><strong>Дата создания</strong></div>
                        <div><strong>Лента</strong></div>
                        <div><strong>Просмотры</strong></div>
                        <div><strong>Дочитывания</strong></div>
                    </div>
                    <div style="clear: both"></div>
                    <div id="pubs"></div>
                </td>
            </tr>
        </table>
    </div>

    </body>
</html>
