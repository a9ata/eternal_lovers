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
      <div class="catalog__filters">
        <div class="catalog__filter catalog__filter--price">
            <h2 class="catalog__filter-title">Сортировать по цене</h2>
            <ul class="catalog__filter-list">
                <li class="catalog__filter-item"><label>15 000 - 30 000 <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>30 000 - 50 000 <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>50 000 - 100 000 <input type="checkbox"></label></li>
            </ul>
        </div>
        <div class="catalog__filter catalog__filter--silhouette">
            <h2 class="catalog__filter-title">Силуэт</h2>
            <ul class="catalog__filter-list">
                <li class="catalog__filter-item"><label>Пышный <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>A-силуэт <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Русалка <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Прямой <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Короткий <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Годе <input type="checkbox"></label></li>
            </ul>
        </div>
        <div class="catalog__filter catalog__filter--sort">
            <h2 class="catalog__filter-title">Сортировать</h2>
            <ul class="catalog__filter-list">
                <li class="catalog__filter-item"><label>Мужские костюмы <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Головные уборы <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Обувь <input type="checkbox"></label></li>
                <li class="catalog__filter-item"><label>Букеты <input type="checkbox"></label></li>
            </ul>
        </div>
    </div>
    <div class="catalog__items" id="catalog-items">
          
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
  </body>
</html>