#!/usr/bin/env php
<?php
error_reporting(6135); // errors and warnings
array_shift($_SERVER["argv"]);

$usersFile = 'adminer/config/users.php';

$user = $_SERVER["argv"][0];
$pass = $_SERVER["argv"][1];

$users = include($usersFile);

if (!is_array($users)) {
    $users = array();
}

if (array_key_exists($user, $users)) {
    echo "User $user istnieje!";
    exit;
}

$passSha = sha1($pass);

echo $user . ' : ' . $passSha;

$users[ $user ] = $passSha;

file_put_contents($usersFile, '<?php return ' . var_export($users, true) . ';');



