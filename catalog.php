<?php
session_start();
require_once 'config/db.php';

// Fetching products from the database
function getProducts($min_price = 0, $max_price = 100000, $manufacturers = [], $types = []) {
  global $conn;
  
  $query = "SELECT * FROM product WHERE price BETWEEN ? AND ?";
  $params = [$min_price, $max_price];
  
  if (!empty($manufacturers)) {
      $query .= " AND manufacturer IN (" . str_repeat('?,', count($manufacturers) - 1) . "?)";
      $params = array_merge($params, $manufacturers);
  }

  if (!empty($types)) {
      $query .= " AND type IN (" . str_repeat('?,', count($types) - 1) . "?)";
      $params = array_merge($params, $types);
  }
  
  $stmt = $conn->prepare($query);
  $stmt->bind_param(str_repeat('i', 2) . str_repeat('s', count($manufacturers) + count($types)), ...$params);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_all(MYSQLI_ASSOC);
}


// Fetching unique manufacturers
function getManufacturers() {
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT manufacturer FROM product");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetching unique types
function getTypes() {
    global $conn;
    $stmt = $conn->prepare("SELECT DISTINCT type FROM product");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("SELECT photo FROM product WHERE id_product = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->bind_result($photo);
  $stmt->fetch();
  $stmt->close();

  if ($photo) {
      header("Content-Type: image/jpeg");
      echo $photo;
  } else {
      // Обработка случая, когда фото не найдено
      header("Content-Type: image/jpeg");
      echo file_get_contents('path/to/default/image.jpg');
  }
}

$min_price = isset($_POST['min_price']) ? intval($_POST['min_price']) : 0;
$max_price = isset($_POST['max_price']) ? intval($_POST['max_price']) : 100000;
$selected_manufacturers = isset($_POST['manufacturers']) ? $_POST['manufacturers'] : [];
$selected_types = isset($_POST['types']) ? $_POST['types'] : [];

$products = getProducts($min_price, $max_price, $selected_manufacturers, $selected_types);
$manufacturers = getManufacturers();
$types = getTypes();
?>
<!doctype html>
<html lang="en,ru">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto"/>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
<section class="catalog">
    <h1 class="catalog__title">Каталог</h1>
    <form method="post" action="">
        <div class="catalog__filters">
            <div class="catalog__filter catalog__filter--price">
                <h2 class="catalog__filter-title">Сортировать по цене</h2>
                <ul class="catalog__filter-list">
                    <li class="catalog__filter-item">
                        <label>3 000 - 15 000 <input type="checkbox" name="price_range" value="3000-15000" <?php echo $min_price == 3000 && $max_price == 15000 ? 'checked' : ''; ?>></label>
                    </li>
                    <li class="catalog__filter-item">
                        <label>15 000 - 30 000 <input type="checkbox" name="price_range" value="15000-30000" <?php echo $min_price == 15000 && $max_price == 30000 ? 'checked' : ''; ?>></label>
                    </li>
                    <li class="catalog__filter-item">
                        <label>30 000 - 50 000 <input type="checkbox" name="price_range" value="30000-50000" <?php echo $min_price == 30000 && $max_price == 50000 ? 'checked' : ''; ?>></label>
                    </li>
                    <li class="catalog__filter-item">
                        <label>50 000 - 100 000 <input type="checkbox" name="price_range" value="50000-100000" <?php echo $min_price == 50000 && $max_price == 100000 ? 'checked' : ''; ?>></label>
                    </li>
                </ul>
            </div>
            <div class="catalog__filter catalog__filter--manufacturer">
                <h2 class="catalog__filter-title">Производитель</h2>
                <ul class="catalog__filter-list">
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <li class="catalog__filter-item">
                            <label><?php echo htmlspecialchars($manufacturer['manufacturer']); ?> 
                            <input type="checkbox" name="manufacturers[]" value="<?php echo htmlspecialchars($manufacturer['manufacturer']); ?>" <?php echo in_array($manufacturer['manufacturer'], $selected_manufacturers) ? 'checked' : ''; ?>></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="catalog__filter catalog__filter--type">
                <h2 class="catalog__filter-title">Тип</h2>
                <ul class="catalog__filter-list">
                    <?php foreach ($types as $type): ?>
                        <li class="catalog__filter-item">
                            <label><?php echo htmlspecialchars($type['type']); ?> 
                            <input type="checkbox" name="types[]" value="<?php echo htmlspecialchars($type['type']); ?>" <?php echo in_array($type['type'], $selected_types) ? 'checked' : ''; ?>></label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <button type="submit" class="filter__btn">Фильтровать</button>
    </form>
    <div class="catalog__items" id="catalog-items">
        <?php foreach ($products as $product): ?>
            <div class="catalog__item">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['photo']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="catalog__item-image">
                <div class="catalog__item-icons">
                    <form action="handle_action.php" method="POST" class="catalog__item-form">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id_product']); ?>">
                        
                        <button type="submit" name="action" value="add_to_cart" class="catalog__item-basket">
                            <img src="public/icon/ph_basket-thin.svg" alt="Basket">
                        </button>
                        
                        <button type="submit" name="action" value="add_to_favorite" class="catalog__item-favorite">
                            <img src="public/icon/ph_heart-thin.svg" alt="Favorite">
                        </button>
                    </form>
                </div>
                <p class="catalog__item-price"><?php echo number_format($product['price'], 0, ',', ' '); ?> руб.</p>
                <p class="catalog__item-title"><?php echo htmlspecialchars($product['title']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
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
<script type="module" src="heart_active.js"></script>
</body>
</html>