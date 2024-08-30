<?php
session_start();
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $user_id = $_SESSION['id_user'];  // Убедитесь, что пользователь вошел в систему
    
    if ($_POST['action'] === 'add_to_cart') {
        // Добавление в корзину с поддержкой количества
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $stmt = $conn->prepare("INSERT INTO cart (status, id_user, id_product, quantity) VALUES ('не оплачен', ?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
    } elseif ($_POST['action'] === 'add_to_favorite') {
        // Добавление в избранное, с проверкой на существование
        $stmt = $conn->prepare("SELECT * FROM favorite WHERE id_user = ? AND id_product = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {  // Если товар еще не в избранном
            $stmt = $conn->prepare("INSERT INTO favorite (id_user, id_product) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        }
    } elseif ($_POST['action'] === 'remove_from_favorite') {
        // Удаление из избранного
        $stmt = $conn->prepare("DELETE FROM favorite WHERE id_user = ? AND id_product = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    // Если запрос был выполнен через AJAX, возвращаем JSON-ответ
    if (isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Перенаправление пользователя обратно в каталог
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
