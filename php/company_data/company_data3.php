<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

// Проверка наличия файлов и подключение
if (!file_exists('./company_array.php')) {
    echo json_encode(["message" => "Файл company_array.php не найден"]);
    exit;
}
require_once './company_array.php';

if (!file_exists('./../registration_and_authorization/create_table.php')) {
    echo json_encode(["message" => "Файл create_table.php не найден"]);
    exit;
}
require_once './../registration_and_authorization/create_table.php';

// Получение данных из формы
$company_logo = $_FILES['company-logo'];
$company_lang = [
    'rus' => isset($_POST['rus']),
    'eng' => isset($_POST['eng']),
    'uzb' => isset($_POST['uzb']),
];
$company_desc = htmlspecialchars(trim($_POST['company-desc']));
$company_phone = htmlspecialchars(trim($_POST['company-phone']));
$social_networks = [
    'instagram' => htmlspecialchars(trim($_POST['instagram'])),
    'facebook' => htmlspecialchars(trim($_POST['facebook'])),
    'tiktok' => htmlspecialchars(trim($_POST['tiktok'])),
    'telegram' => htmlspecialchars(trim($_POST['telegram'])),
    'youtube' => htmlspecialchars(trim($_POST['youtube'])),
    'whatsapp' => htmlspecialchars(trim($_POST['whatsapp'])),
];
$currency = htmlspecialchars(trim($_POST['currency']));
$working_hours = [
    'mon' => isset($_POST['mon']) ? [$_POST['mon-start'] ?? '', $_POST['mon-end'] ?? ''] : null,
    'tue' => isset($_POST['tue']) ? [$_POST['tue-start'] ?? '', $_POST['tue-end'] ?? ''] : null,
    'wed' => isset($_POST['wed']) ? [$_POST['wed-start'] ?? '', $_POST['wed-end'] ?? ''] : null,
    'thu' => isset($_POST['thu']) ? [$_POST['thu-start'] ?? '', $_POST['thu-end'] ?? ''] : null,
    'fri' => isset($_POST['fri']) ? [$_POST['fri-start'] ?? '', $_POST['fri-end'] ?? ''] : null,
    'sat' => isset($_POST['sat']) ? [$_POST['sat-start'] ?? '', $_POST['sat-end'] ?? ''] : null,
    'sun' => isset($_POST['sun']) ? [$_POST['sun-start'] ?? '', $_POST['sun-end'] ?? ''] : null,
];
$company_address = htmlspecialchars(trim($_POST['address']));

// Проверка обязательных полей
if (!empty($company_desc) && !empty($company_phone) && !empty($currency) && !empty($company_address)) {
    try {
        // Загружаем данные компании из сессии
        if (isset($_SESSION['company_data'])) {
            $company_array = $_SESSION['company_data'];
        } else {
            $company_array = [];
        }

        // Обновляем массив новыми данными
        $company_array['company_lang'] = $company_lang;
        $company_array['company_desc'] = $company_desc;
        $company_array['company_phone'] = $company_phone;
        $company_array['social_networks'] = $social_networks;
        $company_array['currency'] = $currency;
        $company_array['working_hours'] = $working_hours;
        $company_array['company_address'] = $company_address;

        // Обработка загрузки логотипа компании
        if ($company_logo['size'] > 0 && $company_logo['size'] <= 10 * 1024 * 1024) {
            $allowed_extensions = ['jpg', 'png', 'svg'];
            $file_extension = pathinfo($company_logo['name'], PATHINFO_EXTENSION);

            if (in_array($file_extension, $allowed_extensions)) {
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $upload_file = $upload_dir . basename($company_logo['name']);
                if (move_uploaded_file($company_logo['tmp_name'], $upload_file)) {
                    $company_array['company_logo'] = $upload_file;
                } else {
                    throw new Exception("Ошибка при загрузке файла.");
                }
            } else {
                throw new Exception("Недопустимый формат файла.");
            }
        }

        // Сохраняем обновленные данные обратно в сессию
        $_SESSION['company_data'] = $company_array;

        // Добавление данных в таблицу companies
        $stmt = $conn->prepare("INSERT INTO companies (company_name, company_type, company_platform, bot_token, company_logo, company_lang, company_desc, company_phone, social_networks, currency, working_hours, company_address) VALUES (:company_name, :company_type, :company_platform, :bot_token, :company_logo, :company_lang, :company_desc, :company_phone, :social_networks, :currency, :working_hours, :company_address)");

        $stmt->bindParam(':company_name', $company_array['company_name']);
        $stmt->bindParam(':company_type', $company_array['company_type']);
        $stmt->bindParam(':company_platform', $company_array['company_platform']);
        $stmt->bindParam(':bot_token', $company_array['bot_token']);
        $stmt->bindParam(':company_logo', $company_array['company_logo']);
        $stmt->bindParam(':company_lang', json_encode($company_array['company_lang']));
        $stmt->bindParam(':company_desc', $company_array['company_desc']);
        $stmt->bindParam(':company_phone', $company_array['company_phone']);
        $stmt->bindParam(':social_networks', json_encode($company_array['social_networks']));
        $stmt->bindParam(':currency', $company_array['currency']);
        $stmt->bindParam(':working_hours', json_encode($company_array['working_hours']));
        $stmt->bindParam(':company_address', $company_array['company_address']);

        $stmt->execute();

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

