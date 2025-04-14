<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$IDuser = $_SESSION['id_user'];

echo '<div class="auth_body">';
echo '<h1>Двухфакторная аутентификация</h1>';

include_once("GA/GoogleAuthenticator.php");
$ga = new PHPGangsta_GoogleAuthenticator();

// Проверяем, есть ли секретный ключ для пользователя
$select_user_key = "SELECT secret_key FROM user WHERE id_user = ?";
$stmt = $conn->prepare($select_user_key);
$stmt->bind_param("i", $IDuser);
$stmt->execute();
$result = $stmt->get_result();
$key_user = $result->fetch_assoc();

if (empty($key_user['secret_key'])) {
    // Генерируем новый секретный ключ
    $secret_key_user = $ga->createSecret();
    
    // Сохраняем его в базе данных
    $update_query = "UPDATE user SET secret_key = ? WHERE id_user = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("si", $secret_key_user, $IDuser);
    if ($update_stmt->execute()) {
        echo '<p>Секретный ключ создан и сохранён!</p>';
    } else {
        die("Ошибка обновления ключа: " . $conn->error);
    }
} else {
    $secret_key_user = $key_user['secret_key'];
}

// Генерируем URL для QR-кода
$qrCodeUrl = $ga->getQRCodeGoogleUrl('My First App', $secret_key_user);

// Выводим отладочную информацию
// echo '<p>Секретный ключ: ' . htmlspecialchars($secret_key_user) . '</p>';
// echo '<p>URL для QR-кода: ' . htmlspecialchars($qrCodeUrl) . '</p>';
echo '<img src="' . $qrCodeUrl . '" alt="QR Code">';

?>

<form action="php-handler/verify_code.php?test=$secret_key_user" method="post">
    <input type="text" name="code" placeholder="Введите код" required>
    <button type="submit">Авторизоваться</button>
</form>
</div>
