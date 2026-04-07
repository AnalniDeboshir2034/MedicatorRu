<?php 
$host = 'localhost';
$user = 'a7comby_Medicator_Ru';
$pass = 'a7comby_Medicator_Ru';
$db_name = 'a7comby_Medicator_Ru';

$mysqli = new mysqli($host, $user, $pass, $db_name);

if ($mysqli->connect_error) {
    die("❌ Ошибка подключения к БД: " . $mysqli->connect_error . 
        "<br>Проверь:<br>" .
        "Хост: $host<br>" .
        "БД: $db_name<br>" .
        "Пользователь: $user");
}

$mysqli->set_charset("utf8mb4");

$pdo = null;

?>