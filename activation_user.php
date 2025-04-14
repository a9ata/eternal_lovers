<?php
session_start();

require_once 'models/User.php';
require_once 'config/db.php';

// Проверяем, установлена ли сессия с пользователем для активации
if (isset($_SESSION['act_user'])) {
    $user = $_SESSION['act_user']; // Получаем идентификатор пользователя из сессии
    // SQL запрос для обновления доступа пользователя
    $update_user = "UPDATE user SET accessmail = '1' WHERE id_user='$user'";
    $result = mysqli_query($conn, $update_user); // Выполнение SQL запроса

    header("location: index.php"); // Перенаправление на главную страницу при успехе
} else {
    header("location: index.php"); // Перенаправление на главную страницу при ошибке
    $_SESSION['message'] = 'Error'; // Сообщение об ошибке в сессии
}
?>