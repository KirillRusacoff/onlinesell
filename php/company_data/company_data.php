<?php

session_start();

require_once './company_array.php';

header('Content-Type: application/json; charset=utf-8');

$company_name = htmlspecialchars(trim($_POST['company_name']));
$company_type = htmlspecialchars(trim($_POST['company-type']));
$company_platform = htmlspecialchars(trim($_POST['company-platform']));

if (!empty($company_name) && !empty($company_type) && !empty($company_platform)) {
    try {
        $company_array['company_name'] = $company_name;
        $company_array['company_type'] = $company_type;
        $company_array['company_platform'] = $company_platform;

        // Сохраняем данные в сессии
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




