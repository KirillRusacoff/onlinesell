<?php

require_once './connect_db.php';

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone']));
$pass = trim($_POST['password']);

if (!empty($phone) && !empty($pass)) 
{
    // Авторизация по телефону
    $stmt = $conn->prepare('SELECT phone, pass FROM users WHERE phone = ?');
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_phone, $db_pass);
        $stmt->fetch();

        if (password_verify($pass, $db_pass)) {
            exit;
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Неправильный телефон или пароль."]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Пользователь с таким телефоном не найден."]);
    }
    $stmt->close();

} 
elseif (!empty($email) && !empty($pass)) 
{
    // Авторизация по email
    $stmt = $conn->prepare('SELECT email, pass FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_email, $db_pass);
        $stmt->fetch();

        if (password_verify($pass, $db_pass)) {
            exit;
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Неправильный email или пароль."]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Пользователь с таким email не найден."]);
    }
    $stmt->close();

} 
else 
{
    http_response_code(400);
    echo json_encode(["message" => "Пожалуйста, заполните все поля."]);
}

$conn->close();
