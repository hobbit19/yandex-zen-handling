<?php

include 'bootstrap.php';

use lib\DataGetter;

/**
 *  Отправка статистики в график
 */

$login = isset($_GET['login']) ? $_GET['login'] : '';

echo json_encode(DataGetter::get($login), JSON_NUMERIC_CHECK);