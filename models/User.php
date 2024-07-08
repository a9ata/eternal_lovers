<?php
require_once __DIR__ . '/../config/db.php';

class User {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function register($name, $password) {
        // Проверяем, не существует ли уже такой пользователь
        $stmt = $this->db->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return false; // Пользователь с таким логином уже существует
        }

        // Хэшируем пароль
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставляем нового пользователя в базу данных
        $stmt = $this->db->prepare("INSERT INTO user (name, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $hashed_password);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function login($name, $password) {
        // Ищем пользователя с таким логином
        $stmt = $this->db->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return false; // Пользователь не найден
        }

        $user = $result->fetch_assoc();
        $stmt->close();
        // Проверяем пароль
        if (password_verify($password, $user['password'])) {
            return true; // Авторизация успешна
        } else {
            return false; // Пароль неверный
        }
    }
}
?>