<?php

require_once './connect_db.php';

$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : null;
$phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null;
$pass = trim($_POST['password']);
$pass_double = trim($_POST['password_double']);

if (!empty($pass) && $pass === $pass_double)
{
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    try 
    {
        $sql = "INSERT INTO users (phone, email, pass) VALUES (:phone, :email, :pass)";
        $stmt = $conn->prepare($sql);

        // Связываем параметры с значениями
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass_hash);
        
        // Выполняем запрос
        $stmt->execute();

        echo json_encode(["message" => "Регистрация прошла успешно!"]);

        $message = "Ваш код для верификации аккаунта: $rand_code";

        $headers = array(
            'From' => 'webmaster@example.com',
            'Reply-To' => 'webmaster@example.com',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        mail('$email', 'Код для верификации', $message, $headers);
    }
    catch (PDOException $exception) 
    {
        http_response_code(500);
        echo json_encode(["message" => "Ошибка регистрации: " . $exception->getMessage()]);
    }
}
else 
{
    http_response_code(400);
    echo json_encode(["message" => "Пожалуйста, заполните все поля и убедитесь, что пароли совпадают."]);
}
