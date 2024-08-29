<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['id_user'];  // Убедитесь, что пользователь вошел в систему
    
    if ($_POST['action'] === 'add_to_cart') {
        // Добавление в корзину
        $stmt = $conn->prepare("INSERT INTO cart (status, id_user, id_product) VALUES ('не оплачен', ?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    } elseif ($_POST['action'] === 'add_to_favorite') {
        // Добавление в избранное
        $stmt = $conn->prepare("INSERT INTO favorite (id_user, id_product) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    } elseif ($_POST['action'] === 'remove_from_favorite') {
        // Удаление из избранного
        $stmt = $conn->prepare("DELETE FROM favorite WHERE id_user = ? AND id_product = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    // Перенаправление пользователя обратно в каталог
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
