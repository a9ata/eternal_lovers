<?php ?>
<!doctype html>
<html lang="en,ru">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto"/>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eternal Lovers</title>
  </head>
  <body>
    <header class="header">
      <div class="header__container">
        <div class="header__logo">
          <img src="public/logo_E&L_title.svg" alt="Eternal Lovers" width="57.49px">
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
          </ul>
        </nav>
        <div class="header__icons">
          <a href="contact.php" class="header__icon"><img src="public/icon/hugeicons_contact.svg" alt="Contact"></a>
          <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
          <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
          <a href="profile.php" class="header__icon"><img src="public/icon/iconamoon_profile-light.svg" alt="Profile"></a>
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
    <section class="banner">
      <div class="banner__content">
        <h1 class="banner__title">От платья до праздника — всё в одном месте</h1>
      </div>
    </section>
    <section class="welcome">
      <h2 class="welcome__title">Добро пожаловать в Eternal Lovers!</h2>
      <p class="welcome__text">Мы рады приветствовать вас в нашем свадебном салон-агентстве, где каждая деталь имеет значение.</p>
      <p class="welcome__text">Наша миссия – сделать ваш особенный день поистине незабываемым.</p>
      <p class="welcome__text">От роскошных свадебных платьев и элегантных костюмов до полной организации торжества — мы обеспечим, чтобы каждый момент вашей свадьбы был идеален.</p>
      <p class="welcome__text">Доверьтесь нашему опыту, и мы поможем вам создать свадебную сказку, о которой вы всегда мечтали.</p>
    </section>
    <section id="about" class="about">
      <h2 class="about__title">О нашем свадебном салоне-агентстве</h2>
      <p class="about__text">Мы решили создать расширенную организацию, где есть всё необходимое для невесты и жениха, чтобы им не приходилось искать отдельные салоны и агентства по организации свадьбы.</p>
      <div class="about__container-points">
        <div class="about__points">
          <div class="about__point">
            <p class="about__point-text">1. Удобство для клиентов: Пары, планирующие свадьбу, ценят удобство и экономию времени. Иметь одно место, где они могут выбрать свадебное платье, оформить флористику, выбрать декорации и организовать торжество, упрощает процесс планирования и уменьшает стресс.</p>
          </div>
          <div class="about__point">
            <p class="about__point-text">2. Экспертные советы и помощь: Пары часто ищут профессиональные советы и помощь при планировании свадьбы. В салоне-агентстве "Eternal Lovers" они могут получить экспертные рекомендации от специалистов в области моды, декора, организации мероприятий и прочего.</p>
          </div>
        </div>
        <div class="about__points">
          <div class="about__point">
            <p class="about__point-text">3. Связь и координация: Важно, чтобы все элементы свадьбы гармонично сочетались между собой. Салон-агентство также может обеспечить связь и координацию между различными поставщиками услуг, чтобы убедиться, что свадьба проходит без сучка и задоринки.</p>
          </div>
          <div class="about__point">
            <p class="about__point-text">4. Индивидуальный подход: Каждая свадьба уникальна, и пары часто ищут специальные детали и персонализацию. Салон-агентство "Eternal Lovers" может предложить индивидуальный подход к каждой паре, помогая им воплотить их уникальные видения и идеи.</p>
          </div>
        </div>
      </div>
    </section>
    <section id="services" class="services">
      <h2 class="services__title">Наши услуги</h2>
      <div class="services__container">
        <div class="services__list">
          <div class="services__item">
            <img src="public/services-icon/icon_dress.svg" alt="Примерка платья" class="services__icon">
            <p class="services__text">Примерка платья</p>
          </div>
          <div class="services__item">
            <img src="public/services-icon/arcticons_tapemeasure.svg" alt="Подгонка по размеру" class="services__icon">
            <p class="services__text">Подгонка по размеру</p>
          </div>
          <div class="services__item">
            <img src="public/services-icon/icon_iron.svg" alt="Отпаривание" class="services__icon">
            <p class="services__text">Отпаривание</p>
          </div>
        </div>
        <div class="services__list">
          <div class="services__item">
            <img src="public/services-icon/icon_storage.svg" alt="Хранение" class="services__icon">
            <p class="services__text">Хранение</p>
          </div>
          <div class="services__item">
            <img src="public/services-icon/icon_delivery.svg" alt="Доставка" class="services__icon">
            <p class="services__text">Доставка</p>
          </div>
          <div class="services__item">
            <img src="public/services-icon/icon_wedding-organization.svg" alt="Организация свадьбы" class="services__icon">
            <p class="services__text">Организация свадьбы</p>
          </div>
        </div>
      </div>
    </section>
    <section class="process">
      <h2 class="process__title">Процесс организации вашей свадьбы</h2>
      <div class="process__container">
        <div class="process__steps">
          <div class="process__step">
            <h3 class="process__step-title">ВСТРЕЧА</h3>
            <p class="process__step-text">Для начала определяемся насколько мы подходим друг другу. Предстоят месяцы подготовки, за которые мы станем близки. И важно на начальном этапе найти понимание.</p>
          </div>
          <div class="process__step">
            <h3 class="process__step-title">ДОГОВОР И БРИФ</h3>
            <p class="process__step-text">После заключения договора вы заполняете бриф, мы узнаем ваши вкусы, пожелания, видение, любимые рестораны, отношения с родителями, историю знакомства.</p>
          </div>
          <div class="process__step">
            <h3 class="process__step-title">КОНЦЕПЦИЯ</h3>
            <p class="process__step-text">Создаем глобальное видение свадьбы по настроению и программе. Под концепцию предстоит искать подходящую по стилю площадку, фотографа, ведущего, создавать образы.</p>
          </div>
        </div>
        <div class="process__steps">
          <div class="process__step">
            <h3 class="process__step-title">РЕАЛИЗАЦИЯ</h3>
            <p class="process__step-text">Ищем ключевых игроков в команду исполнителей. Далее прорабатываем детали: план дня, сценарий, полиграфия, меню, локации для съемок, стиль съемок, образы пары.</p>
          </div>
          <div class="process__step">
            <h3 class="process__step-title">РЕПЕТИЦИЯ</h3>
            <p class="process__step-text">Репетиция церемонии и ключевых моментов, проговариваем тайминг. Вызываем всех ключевых участников церемонии. Просчитываем каждый шаг. Второго шанса у нас не будет.</p>
          </div>
          <div class="process__step">
            <h3 class="process__step-title">ДЕНЬ СВАДЬБЫ</h3>
            <p class="process__step-text">В этот день вы получаете полную нашу поддержку, чтобы ничто не мешало получать удовольствие. Мы с вами с момента монтажа до последнего гостя. Мы проконтролируем всех подрядчиков и процессы, чтобы все прошло гладко.</p>
          </div>
        </div>
      </div>
    </section>
    <section id="consultation" class="consultation">
      <h2 class="consultation__title">Консультация</h2>
      <p class="consultation__subtitle">Если у Вас остались вопросы,</p>
      <p class="consultation__subtitle">Если Вы готовы сотрудничать с нами,</p>
      <p class="consultation__subtitle">То оставь свои данные для консультации!</p>
      <form class="consultation__form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" class="consultation__input" placeholder="Имя" required>
        <input type="email" class="consultation__input" placeholder="Mail" required>
        <input type="tel" class="consultation__input" placeholder="8 800 000 00 00" required>
        <input type="text" class="consultation__input" placeholder="Удобная дата для примерки (01.01.2000)" required>
        <input type="text" class="consultation__input" placeholder="Планируемая дата свадьбы" required>
        <input type="text" class="consultation__input" placeholder="Мой российский размер" required>
        <textarea class="consultation__textarea" placeholder="Я хочу примерить следующие платья: (перечислить)" required></textarea>
        <label>Выберите услуги:</label>
        <div class="dropdown">
          <button type="button" class="dropdown-button">Услуги</button>
          <div class="dropdown-content">
            <div>
              <input type="checkbox" id="usluga1" name="services[]" value="Примерка платья">
              <label for="usluga1">Примерка платья</label>
            </div>
            <div>
              <input type="checkbox" id="usluga2" name="services[]" value="Подгонка по размеру">
              <label for="usluga2">Подгонка по размеру</label>
            </div>
            <div>
              <input type="checkbox" id="usluga3" name="services[]" value="Отпаривание">
              <label for="usluga3">Отпаривание</label>
            </div>
            <div>
              <input type="checkbox" id="usluga4" name="services[]" value="Хранение">
              <label for="usluga4">Хранение</label>
            </div>
            <div>
              <input type="checkbox" id="usluga5" name="services[]" value="Организация свадьбы">
              <label for="usluga5">Организация свадьбы</label>
            </div>
            <div>
              <input type="checkbox" id="usluga6" name="services[]" value="Фотограф">
              <label for="usluga6">Фотограф</label>
            </div>
            <div>
              <input type="checkbox" id="usluga7" name="services[]" value="Видеограф">
              <label for="usluga7">Видеограф</label>
            </div>
            <div>
              <input type="checkbox" id="usluga8" name="services[]" value="Ди-джей">
              <label for="usluga8">Ди-джей</label>
            </div>
            <div>
              <input type="checkbox" id="usluga9" name="services[]" value="Ведущий">
              <label for="usluga9">Ведущий</label>
            </div>
            <div>
              <input type="checkbox" id="usluga10" name="services[]" value="Транспорт">
              <label for="usluga10">Транспорт</label>
            </div>
            <div>
              <input type="checkbox" id="usluga11" name="services[]" value="Флористика">
              <label for="usluga11">Флористика</label>
            </div>
            <div>
              <input type="checkbox" id="usluga12" name="services[]" value="Флористика">
              <label for="usluga11">Стиль свадьбы</label>
            </div>
          </div>
        </div>

        <label>Место проведения:</label>
        <div class="dropdown">
          <button type="button" class="dropdown-button">Место проведения</button>
          <div class="dropdown-content">
            <div>
              <input type="checkbox" id="venue1" name="venue[]" value="Artiland">
              <label for="venue1">Artiland</label>
            </div>
            <div>
              <input type="checkbox" id="venue2" name="venue[]" value="Жан Реми">
              <label for="venue2">Жан Реми</label>
            </div>
            <div>
              <input type="checkbox" id="venue3" name="venue[]" value="Carlton">
              <label for="venue3">Carlton</label>
            </div>
            <div>
              <input type="checkbox" id="venue4" name="venue[]" value="Вилла Ротонда">
              <label for="venue4">Вилла Ротонда</label>
            </div>
            <div>
              <input type="checkbox" id="venue5" name="venue[]" value="ArtVillage">
              <label for="venue5">ArtVillage</label>
            </div>
          </div>
        </div>
        </select>
        <button type="submit" class="consultation__button">Оставить заявку</button>
      </form>
    </section>
    <footer class="footer">
      <div class="footer__container">
        <div class="footer__logo">
          <img src="public/logo_E&L_title.svg" alt="Eternal Lovers">
        </div>
        <nav class="footer__nav">
            <ul class="footer__nav-list">
              <li class="footer__nav-item"><a href="catalog.php" class="footer__nav-link">Каталог</a></li>
              <li class="footer__nav-item"><a href="#consultation" class="footer__nav-link">Консультация</a></li>
              <li class="footer__nav-item"><a href="#services" class="footer__nav-link">Услуги</a></li>
            </ul>
            <ul class="footer__nav-list">
              <li class="footer__nav-item"><a href="#about" class="footer__nav-link">О нас</a></li>
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
    <script src="burger.js"></script>
    <script src="profile.js"></script>
    <script src="dropdown.js"></script>
  </body>
</html>
