<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['id_user'])) {
    // Если пользователь не авторизован, перенаправляем на страницу входа
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['id_user'];

    // Добавляем товар в корзину
    $stmt = $conn->prepare("INSERT INTO cart (status, id_user, id_product) VALUES ('Не оплачен', ?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        // Перенаправляем обратно в каталог
        header("Location: catalog.php");
        exit();
    } else {
        echo "Ошибка при добавлении товара в корзину: " . $conn->error;
    }
}
?>
