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
                <th class="cart-header__quantity">Количество</th>
                <th class="cart-header__total">Сумма</th>
                <th class="cart-header__remove"></th>
              </tr>
            </thead>
            <tbody>
              <tr class="cart-item">
                <td class="cart-item__product"><img src="public/catalog/lush-dress.svg" alt="Product Image" width="155px"></td>
                <td class="cart-item__name">Свадебное платье</td>
                <td class="cart-item__price">120 000 руб.</td>
                <td class="cart-item__quantity">
                    <div class="quantity">
                        <button onclick="changeQuantity(-1)">-</button>
                        <input type="number" class="quantity-input" value="1" min="1" onchange="updateTotal()">
                        <button onclick="changeQuantity(1)">+</button>
                    </div>
                </td>
                <td class="cart-item__total" id="total-price">120 000 руб.</td>
                <td class="cart-item__remove trash-icon"><img src="public/icon/iconoir_trash-solid.svg" alt="Delete"></td>
              </tr>
            </tbody>
        </table>
        <div class="total-container">
            <div class="total-text">Общая стоимость заказа:</div>
            <div id="overall-total" class="total-price">120 000 руб.</div>
        </div>
        <a href="#" class="pay-button">Оплатить</a>
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