<?php

session_start();

require_once './company_array.php';

header('Content-Type: application/json; charset=utf-8');

$bot_token = htmlspecialchars(trim($_POST['token']));

if (!empty($bot_token)) {
    try {
        // Проверяем, что данные компании уже сохранены в сессии
        if (isset($_SESSION['company_data'])) {
            $company_array = $_SESSION['company_data'];
        } else {
            // Если данные компании отсутствуют в сессии, создаем новый массив
            $company_array = [];
        }

        // Добавляем $bot_token в массив компании
        $company_array['bot_token'] = $bot_token;

        // Сохраняем обновленный массив обратно в сессию
        $_SESSION['company_data'] = $company_array;

        echo json_encode([
            "message" => "Данные о компании добавлены успешно!",
            "data" => $company_array
        ]);

    } catch (Exception $exception) {
        http_response_code(500);
        echo json_encode(["message" => "Ошибка: " . $exception->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Пожалуйста, заполните все поля"]);
}
?>
