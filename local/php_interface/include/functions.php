<?php
use Bitrix\Main\Diag\Debug;

function deb($data, $title = '')
{
    Debug::dump($data, $title);
}

function debf($data, $title = '')
{
    $title = empty($title) ? date('Y-m-d H:i:s') : $title . ' (' . date('Y-m-d H:i:s') . ')';
    Debug::dumpToFile($data, $title, '/log.txt');
}