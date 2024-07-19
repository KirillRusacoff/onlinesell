<?php

require_once 'connect_db.php';

try {
    // Таблица пользователей
    $table = "CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        phone VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        pass VARCHAR(255) NOT NULL
    )";

    // Таблица компаний
    $table2 = "CREATE TABLE IF NOT EXISTS companies (
        id INT PRIMARY KEY AUTO_INCREMENT,
        company_name VARCHAR(255),
        company_type VARCHAR(255),
        company_platform VARCHAR(255),
        bot_token VARCHAR(255),
        company_logo VARCHAR(255),
        company_lang VARCHAR(255),
        company_desc TEXT,
        company_phone VARCHAR(255),
        social_networks TEXT,
        currency VARCHAR(255),
        working_hours TEXT,
        company_address VARCHAR(255)
    )";

    // Таблица категорий
    $table3 = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        category_logo VARCHAR(255) NOT NULL,
        category_title VARCHAR(255) NOT NULL
    )";
    
    $conn->exec($table);
    $conn->exec($table2);
    $conn->exec($table3);

    echo "Таблицы 'users' и 'companies' успешно созданы! \n";
} catch (PDOException $exception) {
    var_dump("Ошибка: " . $exception->getMessage() . "\n");
    die();
}
