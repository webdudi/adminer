<?php
function __invoke_auth_basic()
{
    header('WWW-Authenticate: Basic realm="Wymagana autoryzacja"');
    header('HTTP/1.0 401 Unauthorized');
    echo '<h1>DostÄ<99>p zabroniony.</h1>';
    exit;
}

$users = include('config/users.php');

if (isset($_SERVER['Authorization'])) {
    list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['Authorization'], 6)));
}

if (array_key_exists($_SERVER['PHP_AUTH_USER'], $users)) {
    $user['user'] = $_SERVER['PHP_AUTH_USER'];
    $user['pass'] = $users[ $user['user'] ];
}

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || !($_SERVER['PHP_AUTH_USER'] == $user['user'] && sha1($_SERVER['PHP_AUTH_PW']) == $user['pass'])) {
    __invoke_auth_basic();
    exit;
}