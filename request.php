<?php
// Подключение к базе данных
require_once 'config/db.php';

// Функция для выполнения запроса и получения результата
function executeQuery($query) {
    global $conn;
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
function getClientsWithTotalOrders() {
    global $conn;
    $stmt = $conn->prepare("
        SELECT u.name, u.email, SUM(s.price) as total_amount
        FROM user u
        JOIN message m ON u.id_user = m.id_user
        JOIN service s ON m.id_service = s.id_service
        GROUP BY u.id_user
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}


// Запросы
// 1. Получить список всех свадебных платьев в наличии по определенному производителю
$query = "SELECT DISTINCT manufacturer FROM product WHERE type = 'Платье'";
$manufacturers = executeQuery($query);

// 2. Получить список всех услуг, предоставляемых свадебным салоном
$query2 = "SELECT * FROM service";
$services = executeQuery($query2);

// 3. Получить список клиентов, сделавших заказ на свадебное платье
$query3 = "SELECT user.name, user.email, product.title FROM user 
           JOIN cart ON user.id_user = cart.id_user 
           JOIN product ON cart.id_product = product.id_product 
           WHERE product.type = 'платье'";
$clients = executeQuery($query3);

// 4. Получить список клиентов, ожидающих примерку свадебного платья
$query4 = "SELECT user.name, user.email, message.date_fitt FROM user 
           JOIN message ON user.id_user = message.id_user 
           WHERE message.date_fitt IS NOT NULL";
$fitting_clients = executeQuery($query4);

// 5. Получить список клиентов, у которых заказы на свадебные услуги ожидают оплаты
$query5 = "SELECT user.name, user.email, cart.status FROM user 
           JOIN cart ON user.id_user = cart.id_user 
           WHERE cart.status = 'не оплачен'";
$unpaid_orders = executeQuery($query5);

$clients = getClientsWithTotalOrders();
?>

<!doctype html>
<html lang="en,ru">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto"/>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eternal Lovers</title>
</head>
<body>
<header class="header">
    <div class="header__container">
        <div class="header__logo">
            <a href="index.php"><img src="public/logo_E&L_title.svg" alt="Eternal Lovers" width="57.49px"></a>
        </div>
        <nav class="header__nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="index.php#about" class="nav__link">О нас</a></li>
                <li class="nav__item"><a href="index.php#consultation" class="nav__link">Консультация</a></li>
                <li class="nav__item"><a href="index.php#services" class="nav__link">Услуги</a></li>
                <li class="nav__item"><a href="blog.php" class="nav__link">Блог</a></li>
                <li class="nav__item"><a href="portfolio.php" class="nav__link">Портфолио</a></li>
                <li class="nav__item"><a href="reviews.php" class="nav__link">Отзывы</a></li>
            </ul>
        </nav>
        <div class="header__icons">
            <a href="contact.php" class="header__icon"><img src="public/icon/hugeicons_contact.svg" alt="Contact"></a>
            <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
            <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
            <?php if (isset($_SESSION['name'])): ?>
                <a href="profile.php" class="header__icon">
                    <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
                    <?php echo $_SESSION['name'] ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="header__btn">
            <div class="menu-btn">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <nav class="header__menu-burger">
            <li><a href="index.php#about" class="nav__link">О нас</a></li>
            <li><a href="index.php#consultation" class="nav__link">Консультация</a></li>
            <li><a href="index.php#services" class="nav__link">Услуги</a></li>
            <li><a href="blog.php" class="nav__link">Блог</a></li>
            <li><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li><a href="reviews.php" class="nav__link">Отзывы</a></li>
        </nav>
    </div>
</header>
<section class="request">
    <div class="btn__request">
        <a href="admin.php" class="btn__request-link">Перейти к админ-панели</a>
    </div>
    <h2>Список свадебных платьев по производителю</h2>
    <form method="POST" action="">
        <label for="manufacturer">Выберите производителя:</label>
        <select name="manufacturer" id="manufacturer" required>
            <?php foreach ($manufacturers as $man): ?>
                <option value="<?php echo htmlspecialchars($man['manufacturer']); ?>">
                    <?php echo htmlspecialchars($man['manufacturer']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Показать платья</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manufacturer'])) {
        $selected_manufacturer = $_POST['manufacturer'];
        $query = "SELECT * FROM product WHERE manufacturer = '$selected_manufacturer' AND type = 'Платье'";
        $products = executeQuery($query);

        if (!empty($products)) {
            echo "<h2>Список свадебных платьев по производителю: " . htmlspecialchars($selected_manufacturer) . "</h2><ul>";
            foreach ($products as $product) {
                echo "<li>" . htmlspecialchars($product['title']) . " - " . number_format($product['price'], 0, ',', ' ') . " руб.</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Нет свадебных платьев для производителя '" . htmlspecialchars($selected_manufacturer) . "'.</p>";
        }
    }
    ?>

    <h2>Список всех услуг</h2>
    <ul>
        <?php foreach ($services as $service): ?>
            <li><?php echo htmlspecialchars($service['title']); ?> - <?php echo htmlspecialchars($service['price']); ?> руб.</li>
        <?php endforeach; ?>
    </ul>

    <h2>Список клиентов, сделавших заказы на свадебные услуги с указанием общей суммы заказов</h2>
    <ul>
        <?php foreach ($clients as $client): ?>
            <li><?php echo htmlspecialchars($client['name']); ?> - <?php echo htmlspecialchars($client['email']); ?> - Общая сумма заказов: <?php echo htmlspecialchars($client['total_amount']); ?> руб.</li>
        <?php endforeach; ?>
    </ul>

    <h2>Список клиентов, ожидающих примерку</h2>
    <ul>
        <?php foreach ($fitting_clients as $fitting_client): ?>
            <li><?php echo htmlspecialchars($fitting_client['name']); ?> - <?php echo htmlspecialchars($fitting_client['email']); ?> - Дата примерки: <?php echo htmlspecialchars($fitting_client['date_fitt']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Список клиентов с неоплаченными заказами</h2>
    <ul>
        <?php foreach ($unpaid_orders as $unpaid_order): ?>
            <li><?php echo htmlspecialchars($unpaid_order['name']); ?> - <?php echo htmlspecialchars($unpaid_order['email']); ?> - Статус: <?php echo htmlspecialchars($unpaid_order['status']); ?></li>
        <?php endforeach; ?>
    </ul>
</section>
<footer class="footer">
    <div class="footer__container">
        <div class="footer__logo">
            <img src="public/logo_E&L_title.svg" alt="Eternal Lovers">
        </div>
        <nav class="footer__nav">
            <ul class="footer__nav-list">
                <li class="footer__nav-item"><a href="index.php#consultation" class="footer__nav-link">Консультация</a></li>
                <li class="footer__nav-item"><a href="index.php#services" class="footer__nav-link">Услуги</a></li>
            </ul>
            <ul class="footer__nav-list">
                <li class="footer__nav-item"><a href="index.php#about" class="footer__nav-link">О нас</a></li>
                <li class="footer__nav-item"><a href="blog.php" class="footer__nav-link">Блог</a></li>
                <li class="footer__nav-item"><a href="portfolio.php" class="footer__nav-link">Портфолио</a></li>
                <li class="footer__nav-item"><a href="reviews.php" class="footer__nav-link">Отзывы</a></li>
            </ul>
        </nav>
        <div class="footer__socials">
            <a href="#" class="footer__social-link"><img src="public/icon_social-media/streamline_instagram-solid.svg" alt="Instagram"></a>
            <a href="#" class="footer__social-link"><img src="public/icon_social-media/ic_baseline-telegram.svg" alt="Telegram"></a>
            <a href="#" class="footer__social-link"><img src="public/icon_social-media/mingcute_vkontakte-fill.svg" alt="VK"></a>
        </div>
        <div class="footer__contacts">
            <p class="footer__contacts-phone">8 800 888 88 88</p>
            <p class="footer__contacts-hours">Работаем с 10:00 до 20:00</p>
            <p class="footer__contacts-address">117149, г. Москва, ул. Нежинская, д. 7, кв. 1</p>
            <p class="footer__contacts-metro">Метро "Славянский бульвар" или "Минская"</p>
            <p class="footer__contacts-email"><img src="public/icon/material-symbols-light_mail-outline.svg" alt=""><a href="mailto:info@eternal-lovers.ru">info@eternal-lovers.ru</a></p>
        </div>
        <div class="footer__copyright">
            <p class="footer__copyright-text">© 2024 "Eternal Lovers"</p>
        </div>
    </div>
</footer>
<script type="module" src="burger.js"></script>
</body>
</html>