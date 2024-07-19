<?php

$conn_name = 'root';
$conn_pass = '';
$host = 'localhost';
$db_name = 'onlinesell-web-db';
$rand_code = rand(1000, 9999);

try 
{   
    $conn = new PDO("mysql:host=$host;dbname=$db_name;", $conn_name, $conn_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Подключение к БД успешно! \n";
} 
catch (PDOException $exception) 
{
    var_dump("Ошибка: " . $exception->getMessage() . "\n");
    die();
}
