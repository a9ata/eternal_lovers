<?php
require_once 'models/User.php';
require_once 'config/db.php';

session_start();

$error = '';

if (isset($_POST['submit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        // Создаем экземпляр класса User
        $user = new User();
    
        // Вызываем метод login объекта класса User
        $access = $user->login($email, $password);

        if(password_verify($password, $InfoUser['password'])){
            $_SESSION['email'] = $InfoUser['email'];
            $_SESSION['id_user'] = $InfoUser['id_user'];
            if(empty($InfoUser['secret_key'])){
                header("location: index.php");
            } else {
                header("location: form_ga.php");
            }
        }
        if ($access !== false) {
            
            // Авторизация успешна, перенаправляем на соответствующую страницу
            $_SESSION['username'] = $email;
            $_SESSION['is_admin'] = $access == 1;

            $check_user = "SELECT * FROM user WHERE email = '$email'";
            $result_check_user = mysqli_query($conn, $check_user);
            $check_user2 = mysqli_fetch_object($result_check_user);
            $test2 = $check_user2 -> id_user;

            if ($info_user['accessmail'] == 0) {
                $_SESSION['message'] = 'Вы не подтвердили свою почту';
                header("location: index.php");
                exit();
            }

            $url = "http://localhost/eternal_lovers/activation.php?idu=$test2";
            $to = $email; 
            $subject = 'Подтвердите почту для регистрации'; 
            $message = 'Здравствуйте, уважаемый пользователь! Просим вас подтвердить электронную почту, чтобы вы смогли авторизоваться на нашем сайте. Перейдите по ссылке: '.$url; 
            $headers = 'From: poderbatmelissa@gmail.com'; 

            
            if(mail($to, $subject, $message, $headers)) {
                header("location: index.php"); 
            } else {
                $_SESSION['message'] = 'Мы не смогли отправить вам письмо'; 
                header("location: register.php"); 
            }


            if ($_SESSION['is_admin']) {
                header("Location: admin.php");
            } else {
                header("Location: profile.php");

            }
            exit;
        } else {
            $error = 'Неверное имя пользователя или пароль.';
        }
    }
    if(isset($_POST['g-recaptcha-response'])){
        $reaptcha = $_POST['g-recaptcha-response'];

        if(!$reaptcha){
            $_SESSION['message'] = 'Пожалуйста, подтвердите что вы не робот';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $secretKey = '6Le4qT4qAAAAAHeEXwaXm7ZUoXNuv_WN2a7K7JIe';
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey. '&response='.$recapcha;
            $response = file_get_contents($url);
            $responseKey = json_decode($response, true);
        }
        if($responseKey['success']) {

            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
        
            $check_user = "SELECT * FROM `user` WHERE `email` = '$email'";
            $result = mysqli_query($conn, $check_user);
            $info_user = mysqli_fetch_array($result);
        
            if(empty($info_user['id_user'])) {
                $_SESSION['message'] = 'Неправильный логин или пароль!';
                header("location: login.php");
            } else {
                if(password_verify($password, $info_user['password'])) {
                    $_SESSION['email'] = $info_user['email'];
                    $_SESSION['id_user'] = $info_user['id_user'];
                    header("location: login.php");
                } else {
                    $_SESSION['message'] = 'Неправильный пароль!';
                    header("location: login.php");
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
    <title>Вход</title>
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
            <li class="nav__item"><a href="index.php#about" class="nav__link">О нас</a></li>
            <li class="nav__item"><a href="index.php#consultation" class="nav__link">Консультация</a></li>
            <li class="nav__item"><a href="index.php#services" class="nav__link">Услуги</a></li>
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
    <div class="login-form">
        <h2>Вход</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="email" name="email" placeholder="Почта" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <div class="g-recaptcha" data-sitekey="6Le4qT4qAAAAAMX5A4dtroYdl0UvNxo2FjYjSZvT" data-action="LOGIN"></div>
            <input type="submit" name="submit" class="btn" value="Войти">
            
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
