<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

header('Content-Type: application/json');

$verify_code = $_POST['verify'];

if (!empty($verify_code)) {
    try {
        if ($verify_code === '7777') {
            echo json_encode(["message" => "Верификация прошла успешно!"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Код верификации неверен"]);
        }
    } catch (PDOException $exception) {
        http_response_code(500);
        echo json_encode(["message" => "Ошибка верификации: " . $exception->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Пожалуйста, заполните поле верификации."]);
}