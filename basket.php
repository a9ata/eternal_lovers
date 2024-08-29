<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id_user'];

// Извлекаем товары из корзины для текущего пользователя
$stmt = $conn->prepare("SELECT cart.id_cart, product.title, product.price, product.photo FROM cart JOIN product ON cart.id_product = product.id_product WHERE cart.id_user = ? AND cart.status = 'Не оплачен'");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

$total_price = array_sum(array_column($cart_items, 'price'));
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
          <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
          <a href="#" class="header__icon"><img src="public/icon/iconamoon_profile-light.svg" alt="Profile"></a>
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
    <section class="cart">
      <h2 class="cart__title">Корзина</h2>
      <div class="cart-container">
          <table>
              <thead>
                <tr class="cart-header">
                  <th class="cart-header__product">Продукт</th>
                  <th class="cart-header__name"></th>
                  <th class="cart-header__price">Цена</th>
                  <th class="cart-header__remove"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $item): ?>
                <tr class="cart-item">
                  <td class="cart-item__product"><img src="data:image/jpeg;base64,<?php echo base64_encode($item['photo']); ?>" alt="Product Image" width="155px"></td>
                  <td class="cart-item__name"><?php echo htmlspecialchars($item['title']); ?></td>
                  <td class="cart-item__price"><?php echo number_format($item['price'], 0, ',', ' '); ?> руб.</td>
                  <td class="cart-item__remove trash-icon">
                      <form action="remove_from_cart.php" method="POST">
                          <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($item['id_cart']); ?>">
                          <button type="submit" class="remove-button"><img src="public/icon/iconoir_trash-solid.svg" alt="Delete"></button>
                      </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
          <div class="total-container">
              <div class="total-text">Общая стоимость заказа:</div>
              <div id="overall-total" class="total-price"><?php echo number_format($total_price, 0, ',', ' '); ?> руб.</div>
          </div>
          <form action="checkout.php" method="POST">
              <button type="submit" class="pay-button">Оплатить</button>
          </form>
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