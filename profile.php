<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <title>Профиль</title>
</head>
<body>
<header class="header">
      <div class="header__container">
        <div class="header__logo">
          <a href="index.php" class="nav__link">
            <img src="public/logo_E&L_title.svg" alt="Eternal Lovers" width="57.49px">
          </a>
        </div>
        <nav class="header__nav">
          <ul class="nav__list">
            <li class="nav__item"><a href="catalog.php" class="nav__link">Каталог</a></li>
            <li class="nav__item"><a href="#about" class="nav__link">О нас</a></li>
            <li class="nav__item"><a href="#consultation" class="nav__link">Консультация</a></li>
            <li class="nav__item"><a href="#services" class="nav__link">Услуги</a></li>
            <li class="nav__item"><a href="blog.php" class="nav__link">Блог</a></li>
            <li class="nav__item"><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li class="nav__item"><a href="reviews.php" class="nav__link">Отзывы</a></li>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
              <li class="nav__item"><a href="admin.php" class="nav__link">Админ-панель</a></li>
            <?php endif; ?>
          </ul>
        </nav>
        <div class="header__icons">
          <a href="contact.php" class="header__icon"><img src="public/icon/hugeicons_contact.svg" alt="Contact"></a>
          <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
          <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
          <a href="profile.php" class="header__icon">
            <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
            <?php if (isset($_SESSION['name'])): ?>
                <?php echo htmlspecialchars($_SESSION['name']); ?>
            <?php endif; ?>
          </a>
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
            <li><a href="#about" class="nav__link">О нас</a></li>
            <li><a href="#consultation" class="nav__link">Консультация</a></li>
            <li><a href="#services" class="nav__link">Услуги</a></li>
            <li><a href="blog.php" class="nav__link">Блог</a></li>
            <li><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li><a href="reviews.php" class="nav__link">Отзывы</a></li>
        </nav>
      </div>
    </header>
    <div class="profile">
        <h2>Профиль</h2>
        <div class="profile__user-data">
            <?php if (isset($_SESSION['name'], $_SESSION['email'], $_SESSION['telephone'])): ?>
            <p class="profile__name"><?php echo htmlspecialchars($_SESSION['name']); ?></p><br />
            <p class="profile__email"><?php echo htmlspecialchars($_SESSION['email']); ?></p><br />
            <p class="profile__tel"><?php echo htmlspecialchars($_SESSION['telephone']); ?></p>   
        </div>
        <a href="logout.php">Выйти</a>
        <div class="profile__log">
            <?php else: ?>
            <a href="login.php">Вход</a> 
            <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>   
    </div>
</body>
</html>