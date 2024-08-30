<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = intval($data['cart_id']);
    $quantity = intval($data['quantity']);

    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id_cart = ?");
        $stmt->bind_param("ii", $quantity, $cart_id);
        $stmt->execute();

        // Пересчитываем общую сумму
        $user_id = $_SESSION['id_user'];
        $stmt = $conn->prepare("SELECT SUM(product.price * cart.quantity) as total_price FROM cart JOIN product ON cart.id_product = product.id_product WHERE cart.id_user = ? AND cart.status = 'Не оплачен'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode(['success' => true, 'new_total' => number_format($row['total_price'], 0, ',', ' ')]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
