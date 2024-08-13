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

    public function login($email, $password) {
        // Ищем пользователя с таким email
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return false; // Пользователь не найден
        }

        $user = $result->fetch_assoc();
        $stmt->close();
        // Проверяем пароль
        if (password_verify($password, $user['password'])) {
            // Сохраняем данные пользователя в сессии
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['telephone'] = $user['telephone'];
            $_SESSION['access'] = $user['access'];
            return $user['access']; // Возвращаем уровень доступа
            // return true; // Авторизация успешна
        } else {
            return false; // Пароль неверный
        }
    }
}
?>
