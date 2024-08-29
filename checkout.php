<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

// Обновляем статус товаров в корзине на "Оплачен"
$stmt = $conn->prepare("UPDATE cart SET status = 'Оплачен' WHERE id_user = ? AND status = 'Не оплачен'");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Заказ успешно оплачен!";
    header("Location: basket.php");
    exit();
} else {
    echo "Ошибка при оплате: " . $conn->error;
}
?>
