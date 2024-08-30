<?php
session_start();
require_once 'config/db.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user']; // Получаем ID пользователя из сессии

// Извлекаем товары из избранного для текущего пользователя
$stmt = $conn->prepare("
    SELECT product.id_product, product.title, product.price, product.photo 
    FROM favorite 
    JOIN product ON favorite.id_product = product.id_product 
    WHERE favorite.id_user = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$favorites = $result->fetch_all(MYSQLI_ASSOC);

// Проверяем, есть ли товары в избранном
if (empty($favorites)) {
    $favorites = []; // Устанавливаем пустой массив, если ничего не найдено
}

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
            <li class="nav__item"><a href="catalog.php" class="nav__link">Каталог</a></li>
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
            <li><a href="catalog.php" class="nav__link">Каталог</a></li>
            <li><a href="index.php#about" class="nav__link">О нас</a></li>
            <li><a href="index.php#consultation" class="nav__link">Консультация</a></li>
            <li><a href="index.php#services" class="nav__link">Услуги</a></li>
            <li><a href="blog.php" class="nav__link">Блог</a></li>
            <li><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li><a href="reviews.php" class="nav__link">Отзывы</a></li>
        </nav>
      </div>
    </header>
    <section class="favorites">
        <h1 class="favorites__title">Избранные товары</h1>
        <div class="favorites__items">
            <?php if (empty($favorites)): ?>
              <p>Ваш список избранных товаров пуст.</p>
            <?php else: ?>
              <?php foreach ($favorites as $product): ?>
                <div class="favorites__item">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($product['photo']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="favorites__item-image">
                  <div class="favorites__item-details">
                    <p class="favorites__item-title"><?php echo htmlspecialchars($product['title']); ?></p>
                    <p class="favorites__item-price"><?php echo number_format($product['price'], 0, ',', ' '); ?> руб.</p>
                    <form action="handle_action.php" method="POST" class="favorites__item-form">
                      <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id_product']); ?>">
                      <button type="submit" name="action" value="add_to_cart" class="catalog__item-basket">
                        <img src="public/icon/ph_basket-thin.svg" alt="Basket">
                      </button>
                      <button type="submit" name="action" value="remove_from_favorite" class="favorites__item-remove">Удалить</button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
      <div class="footer__container">
        <div class="footer__logo">
          <img src="public/logo_E&L_title.svg" alt="Eternal Lovers">
        </div>
        <nav class="footer__nav">
            <ul class="footer__nav-list">
              <li class="footer__nav-item"><a href="catalog.php" class="footer__nav-link">Каталог</a></li>
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