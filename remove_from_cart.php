<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = intval($_POST['cart_id']);
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE id_cart = ?");
    $stmt->bind_param("i", $cart_id);
    
    if ($stmt->execute()) {
        header("Location: basket.php");
        exit();
    } else {
        echo "Ошибка при удалении товара из корзины: " . $conn->error;
    }
}
?>
