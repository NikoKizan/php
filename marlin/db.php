<?php
// Данные подключения к базе данных
$driver = 'mysql';
$host = 'localhost';
$db_name = 'blog';
$db_user = 'root';
$db_password = '123123';
$charset = 'utf8';

// Опции для настройки PDO подключения (не обязательно)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Указываем данные для соединения с mysql
$dsn = "$driver:host=$host;db_name=$db_name;charset=$charset";

// Подключение к базе данных с помощью объекта PDO
$pdo = new PDO($dsn, $db_user, $db_password, $options);

?>