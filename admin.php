<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';

// Функции для работы с базой данных

// Получение списка пользователей
function getUsers() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM user");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Получение списка товаров
function getProducts() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM product");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Добавление пользователя
function addUser($name, $email, $telephone, $password, $access) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (name, email, telephone, password, access) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $email, $telephone, $hashed_password, $access);
    return $stmt->execute();
}

// Изменение пользователя
function updateUser($id, $name, $email, $telephone, $access) {
    global $conn;
    $stmt = $conn->prepare("UPDATE user SET name = ?, email = ?, telephone = ?, access = ? WHERE id_user = ?");
    $stmt->bind_param("sssii", $name, $email, $telephone, $access, $id);
    return $stmt->execute();
}

// Удаление пользователя
function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM user WHERE id_user = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Добавление товара
function addProduct($title, $manufacturer, $price, $photo, $quantity, $type) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO product (title, manufacturer, price, photo, quantity, type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsis", $title, $manufacturer, $price, $photo, $quantity, $type);
    return $stmt->execute();
}

// Изменение товара
function updateProduct($id, $title, $manufacturer, $price, $photo, $quantity, $type) {
    global $conn;
    if ($photo !== null) {
        $stmt = $conn->prepare("UPDATE product SET title = ?, manufacturer = ?, price = ?, photo = ?, quantity = ?, type = ? WHERE id_product = ?");
        $stmt->bind_param("ssdsisi", $title, $manufacturer, $price, $photo, $quantity, $type, $id);
    } else {
        $stmt = $conn->prepare("UPDATE product SET title = ?, manufacturer = ?, price = ?, quantity = ?, type = ? WHERE id_product = ?");
        $stmt->bind_param("ssdisi", $title, $manufacturer, $price, $quantity, $type, $id);
    }
    return $stmt->execute();
}

// Удаление товара
function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM product WHERE id_product = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Обработка форм

// Добавление пользователя
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $access = $_POST['access'];
    if (addUser($name, $email, $telephone, $password, $access)) {
        $success = "Пользователь добавлен успешно.";
    } else {
        $error = "Ошибка при добавлении пользователя.";
    }
}

// Изменение пользователя
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $access = $_POST['access'];
    if (updateUser($id, $name, $email, $telephone, $access)) {
        $success = "Пользователь изменен успешно.";
    } else {
        $error = "Ошибка при изменении пользователя.";
    }
}

// Удаление пользователя
if (isset($_POST['delete_user'])) {
    $id = $_POST['id'];
    if (deleteUser($id)) {
        $success = "Пользователь удален успешно.";
    } else {
        $error = "Ошибка при удалении пользователя.";
    }
}

// Добавление товара
if (isset($_POST['add_product'])) {
    $title = $_POST['title'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }
    $quantity = $_POST['quantity'];
    $type = $_POST['type'];
    
    if (addProduct($title, $manufacturer, $price, $photo, $quantity, $type)) {
        $success = "Товар добавлен успешно.";
    } else {
        $error = "Ошибка при добавлении товара.";
    }
}

// Изменение товара
if (isset($_POST['update_product'])) {
    $id = $_POST['id_product'];
    $title = $_POST['title'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $type = $_POST['type'];
    $photo = $_POST['existing_photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    }
    
    if (updateProduct($id, $title, $manufacturer, $price, $photo, $quantity, $type)) {
        $success = "Товар изменен успешно.";
    } else {
        $error = "Ошибка при изменении товара.";
    }
}

// Удаление товара
if (isset($_POST['delete_product'])) {
    $id = $_POST['id_product'];
    if (deleteProduct($id)) {
        $success = "Товар удален успешно.";
    } else {
        $error = "Ошибка при удалении товара.";
    }
}

// Получение списка сервисов
function getServices() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM service");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Добавление сервиса
function addService($title, $price, $description) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO service (title, price, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $title, $price, $description);
    return $stmt->execute();
}

// Изменение сервиса
function updateService($id, $title, $price, $description) {
    global $conn;
    $stmt = $conn->prepare("UPDATE service SET title = ?, price = ?, description = ? WHERE id_service = ?");
    $stmt->bind_param("sisi", $title, $price, $description, $id);
    return $stmt->execute();
}

// Удаление сервиса
function deleteService($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM service WHERE id_service = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Обработка форм

// Добавление сервиса
if (isset($_POST['add_service'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    if (addService($title, $price, $description)) {
        $success = "Сервис добавлен успешно.";
    } else {
        $error = "Ошибка при добавлении сервиса.";
    }
}

// Изменение сервиса
if (isset($_POST['update_service'])) {
    $id = $_POST['id_service'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    if (updateService($id, $title, $price, $description)) {
        $success = "Сервис изменен успешно.";
    } else {
        $error = "Ошибка при изменении сервиса.";
    }
}

// Удаление сервиса
if (isset($_POST['delete_service'])) {
    $id = $_POST['id_service'];
    if (deleteService($id)) {
        $success = "Сервис удален успешно.";
    } else {
        $error = "Ошибка при удалении сервиса.";
    }
}

// Получение списка сообщений
function getMessages() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM message");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Добавление сообщения
function addMessage($date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO message (date_fitt, date_wedding, size, comment, id_user, id_place, id_service) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiii", $date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service);
    return $stmt->execute();
}

// Изменение сообщения
function updateMessage($id_message, $date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service) {
    global $conn;
    $stmt = $conn->prepare("UPDATE message SET date_fitt = ?, date_wedding = ?, size = ?, comment = ?, id_user = ?, id_place = ?, id_service = ? WHERE id_message = ?");
    $stmt->bind_param("sssiiiii", $date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service, $id_message);
    return $stmt->execute();
}

// Удаление сообщения
function deleteMessage($id_message) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM message WHERE id_message = ?");
    $stmt->bind_param("i", $id_message);
    return $stmt->execute();
}

// Обработка форм

// Добавление сообщения
if (isset($_POST['add_message'])) {
    $date_fitt = $_POST['date_fitt'];
    $date_wedding = $_POST['date_wedding'];
    $size = $_POST['size'];
    $comment = $_POST['comment'];
    $id_user = $_POST['id_user'];
    $id_place = $_POST['id_place'];
    $id_service = $_POST['id_service'];
    if (addMessage($date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service)) {
        $success = "Сообщение добавлено успешно.";
    } else {
        $error = "Ошибка при добавлении сообщения.";
    }
}

// Изменение сообщения
if (isset($_POST['update_message'])) {
    $id_message = $_POST['id_message'];
    $date_fitt = $_POST['date_fitt'];
    $date_wedding = $_POST['date_wedding'];
    $size = $_POST['size'];
    $comment = $_POST['comment'];
    $id_user = $_POST['id_user'];
    $id_place = $_POST['id_place'];
    $id_service = $_POST['id_service'];
    if (updateMessage($id_message, $date_fitt, $date_wedding, $size, $comment, $id_user, $id_place, $id_service)) {
        $success = "Сообщение изменено успешно.";
    } else {
        $error = "Ошибка при изменении сообщения.";
    }
}

// Удаление сообщения
if (isset($_POST['delete_message'])) {
    $id_message = $_POST['id_message'];
    if (deleteMessage($id_message)) {
        $success = "Сообщение удалено успешно.";
    } else {
        $error = "Ошибка при удалении сообщения.";
    }
}

// Получение списка сообщений
function getConnections() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM connection");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Добавление сообщения
function addConnection($email, $name, $comment, $id_user) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO connection (email, name, comment, id_user) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $email, $name, $comment, $id_user);
    return $stmt->execute();
}

// Изменение сообщения
function updateConnection($id, $email, $name, $comment, $id_user) {
    global $conn;
    $stmt = $conn->prepare("UPDATE connection SET email = ?, name = ?, comment = ?, id_user = ? WHERE id_connection = ?");
    $stmt->bind_param("sssii", $email, $name, $comment, $id_user, $id);
    return $stmt->execute();
}

// Удаление сообщения
function deleteConnection($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM connection WHERE id_connection = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Обработка форм

// Добавление сообщения
if (isset($_POST['add_connection'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $id_user = $_POST['id_user'];
    if (addConnection($email, $name, $comment, $id_user)) {
        $success = "Сообщение добавлено успешно.";
    } else {
        $error = "Ошибка при добавлении сообщения.";
    }
}

// Изменение сообщения
if (isset($_POST['update_connection'])) {
    $id = $_POST['id_connection'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $id_user = $_POST['id_user'];
    if (updateConnection($id, $email, $name, $comment, $id_user)) {
        $success = "Сообщение изменено успешно.";
    } else {
        $error = "Ошибка при изменении сообщения.";
    }
}

// Удаление сообщения
if (isset($_POST['delete_connection'])) {
    $id = $_POST['id_connection'];
    if (deleteConnection($id)) {
        $success = "Сообщение удалено успешно.";
    } else {
        $error = "Ошибка при удалении сообщения.";
    }
}

// Получение списка корзин
function getCarts() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM cart");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Добавление корзины
function addCart($status, $id_user, $id_product) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO cart (status, id_user, id_product) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $status, $id_user, $id_product);
    return $stmt->execute();
}

// Изменение корзины
function updateCart($id, $status, $id_user, $id_product) {
    global $conn;
    $stmt = $conn->prepare("UPDATE cart SET status = ?, id_user = ?, id_product = ? WHERE id_cart = ?");
    $stmt->bind_param("siii", $status, $id_user, $id_product, $id);
    return $stmt->execute();
}

// Удаление корзины
function deleteCart($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM cart WHERE id_cart = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Обработка форм

// Добавление корзины
if (isset($_POST['add_cart'])) {
    $status = $_POST['status'];
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    if (addCart($status, $id_user, $id_product)) {
        $success = "Корзина добавлена успешно.";
    } else {
        $error = "Ошибка при добавлении корзины.";
    }
}

// Изменение корзины
if (isset($_POST['update_cart'])) {
    $id = $_POST['id_cart'];
    $status = $_POST['status'];
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    if (updateCart($id, $status, $id_user, $id_product)) {
        $success = "Корзина изменена успешно.";
    } else {
        $error = "Ошибка при изменении корзины.";
    }
}

// Удаление корзины
if (isset($_POST['delete_cart'])) {
    $id = $_POST['id_cart'];
    if (deleteCart($id)) {
        $success = "Корзина удалена успешно.";
    } else {
        $error = "Ошибка при удалении корзины.";
    }
}



$users = getUsers();
$products = getProducts();
$services = getServices();
$messages = getMessages();
$connections = getConnections();
$carts = getCarts();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
    <title>Админ-панель</title>
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
        <?php if (isset($_SESSION['name'])); ?>
            <a href="profile.php" class="header__icon">
            <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
            <?php echo $_SESSION['name'] ?>
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
<section class="section-admin">
    <div class="btn__request">
        <a href="request.php" class="btn__request-link">Перейти к запросам</a>
    </div>
    <h1>Админ-панель</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>


    <div class="add">
        <h3 class="add__title">Добавить пользователя</h3>
        <form action="" method="POST" class="add__form">
            <input type="text" class="add__input" name="name" placeholder="Имя" required><br>
            <input type="email" class="add__input" name="email" placeholder="Почта" required><br>
            <input type="text" class="add__input" name="telephone" placeholder="Телефон" required><br>
            <input type="password" class="add__input" name="password" placeholder="Пароль" required><br>
            <input type="number" class="add__input" name="access" placeholder="Уровень доступа" required><br>
            <button type="submit" class="add__button" name="add_user">Добавить пользователя</button>
        </form>

        <?php if (isset($_POST['edit_user'])): ?>
            <?php
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $access = $_POST['access'];
            ?>
            <h3>Изменить пользователя</h3>
            <form action="" class="change__form" method="POST">
                <input type="hidden" class="change__input" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="text" class="change__input" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
                <input type="email" class="change__input" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <input type="text" class="change__input" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>" required><br>
                <input type="number" class="change__input" name="access" value="<?php echo htmlspecialchars($access); ?>" required><br>
                <button type="submit" class="change__button" name="update_user">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>
    <h2>Управление пользователями</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Имя</th>
                <th class="table__header-cell">Email</th>
                <th class="table__header-cell">Телефон</th>
                <th class="table__header-cell">Уровень доступа</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($users as $user): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($user['id_user']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($user['name']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($user['email']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($user['telephone']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($user['access']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id_user']); ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            <input type="hidden" name="telephone" value="<?php echo htmlspecialchars($user['telephone']); ?>">
                            <input type="hidden" name="access" value="<?php echo htmlspecialchars($user['access']); ?>">
                            <button type="submit" name="edit_user" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id_user']); ?>">
                            <button type="submit" name="delete_user" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div class="add">
        <h3>Добавить товар</h3>
        <form action="" method="POST" class="add__form" enctype="multipart/form-data">
            <input type="text" class="add__input" name="title" placeholder="Название товара" required><br>
            <input type="text" class="add__input" name="manufacturer" placeholder="Производитель" required><br>
            <input type="number" class="add__input" step="0.01" name="price" placeholder="Цена товара" required><br>
            <input type="file" class="add__input" name="photo" accept="image/*"><br>
            <input type="number" class="add__input" name="quantity" placeholder="Количество" required><br>
            <input type="text" class="add__input" name="type" placeholder="Тип товара" required><br>
            <button type="submit" class="add__button" name="add_product">Добавить товар</button>
        </form>

        <?php if (isset($_POST['edit_product'])): ?>
            <?php
            $id_product = $_POST['id_product'];
            $title = $_POST['title'];
            $manufacturer = $_POST['manufacturer'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $type = $_POST['type'];
            $photo = $_POST['photo'];
            ?>
            <h3>Изменить товар</h3>
            <form action="" method="POST" class="change__form" enctype="multipart/form-data">
                <input type="hidden" class="change__input" name="id_product" value="<?php echo htmlspecialchars($id_product); ?>">
                <input type="hidden" class="change__input" name="existing_photo" value="<?php echo htmlspecialchars($photo); ?>">
                <input type="text" class="change__input" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br>
                <input type="text" class="change__input" name="manufacturer" value="<?php echo htmlspecialchars($manufacturer); ?>" required><br>
                <input type="number" class="change__input" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br>
                <input type="file" class="change__input" name="photo" accept="image/*"><br>
                <input type="number" class="change__input" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required><br>
                <input type="text" class="change__input" name="type" value="<?php echo htmlspecialchars($type); ?>" required><br>
                <button type="submit" class="change__button" name="update_product">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>
    <h2>Управление товарами</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Название</th>
                <th class="table__header-cell">Производитель</th>
                <th class="table__header-cell">Цена</th>
                <th class="table__header-cell">Фото</th>
                <th class="table__header-cell">Количество</th>
                <th class="table__header-cell">Тип</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($products as $product): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($product['id_product']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($product['title']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($product['manufacturer']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($product['price']); ?></td>
                    <td class="table__cell"><?php echo '<img src="data:image/jpeg;base64,' . base64_encode($product['photo']) . '" class="table__image" />'; ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($product['quantity']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($product['type']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_product" value="<?php echo htmlspecialchars($product['id_product']); ?>">
                            <input type="hidden" name="title" value="<?php echo htmlspecialchars($product['title']); ?>">
                            <input type="hidden" name="manufacturer" value="<?php echo htmlspecialchars($product['manufacturer']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
                            <input type="hidden" name="photo" value="<?php echo htmlspecialchars($product['photo']); ?>">
                            <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>">
                            <input type="hidden" name="type" value="<?php echo htmlspecialchars($product['type']); ?>">
                            <button type="submit" name="edit_product" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_product" value="<?php echo htmlspecialchars($product['id_product']); ?>">
                            <button type="submit" name="delete_product" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="add">
        <!-- Форма для добавления сообщения -->
        <h3>Добавить сообщение</h3>
        <form action="" class="add__form" method="POST">
            <input type="date" class="add__input" name="date_fitt" placeholder="Дата примерки" required><br>
            <input type="date" class="add__input" name="date_wedding" placeholder="Дата свадьбы" required><br>
            <input type="text" class="add__input" name="size" placeholder="Размер" required><br>
            <textarea name="comment" class="add__input" placeholder="Комментарий" required></textarea><br>
            <input type="number" class="add__input" name="id_user" placeholder="ID Пользователя" required><br>
            <input type="number" class="add__input" name="id_place" placeholder="ID Места" required><br>
            <input type="number" class="add__input" name="id_service" placeholder="ID Сервиса" required><br>
            <button type="submit" class="add__button" name="add_message">Добавить сообщение</button>
        </form>

        <!-- Здесь можно добавить код для редактирования сообщения, если нажата кнопка редактирования -->
        <?php if (isset($_POST['edit_message'])): ?>
            <?php
            $id_message = $_POST['id_message'];
            $date_fitt = $_POST['date_fitt'];
            $date_wedding = $_POST['date_wedding'];
            $size = $_POST['size'];
            $comment = $_POST['comment'];
            $id_user = $_POST['id_user'];
            $id_place = $_POST['id_place'];
            $id_service = $_POST['id_service'];
            ?>
            <h3>Изменить сообщение</h3>
            <form action="" method="POST" class="change__form">
                <input type="hidden" class="change__input" name="id_message" value="<?php echo htmlspecialchars($id_message); ?>">
                <input type="date" class="change__input" name="date_fitt" value="<?php echo htmlspecialchars($date_fitt); ?>" required><br>
                <input type="date" class="change__input" name="date_wedding" value="<?php echo htmlspecialchars($date_wedding); ?>" required><br>
                <input type="text" class="change__input" name="size" value="<?php echo htmlspecialchars($size); ?>" required><br>
                <textarea name="comment" class="change__input" required><?php echo htmlspecialchars($comment); ?></textarea><br>
                <input type="number" class="change__input" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" required><br>
                <input type="number" class="change__input" name="id_place" value="<?php echo htmlspecialchars($id_place); ?>" required><br>
                <input type="number" class="change__input" name="id_service" value="<?php echo htmlspecialchars($id_service); ?>" required><br>
                <button type="submit" class="change__button" name="update_message">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>
    <!-- Вывод таблицы с сообщениями -->
    <h2>Управление сообщениями</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Дата примерки</th>
                <th class="table__header-cell">Дата свадьбы</th>
                <th class="table__header-cell">Размер</th>
                <th class="table__header-cell">Комментарий</th>
                <th class="table__header-cell">ID Пользователя</th>
                <th class="table__header-cell">ID Места</th>
                <th class="table__header-cell">ID Сервиса</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($messages as $message): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($message['id_message']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['date_fitt']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['date_wedding']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['size']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['comment']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['id_user']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['id_place']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($message['id_service']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_message" value="<?php echo htmlspecialchars($message['id_message']); ?>">
                            <input type="hidden" name="date_fitt" value="<?php echo htmlspecialchars($message['date_fitt']); ?>">
                            <input type="hidden" name="date_wedding" value="<?php echo htmlspecialchars($message['date_wedding']); ?>">
                            <input type="hidden" name="size" value="<?php echo htmlspecialchars($message['size']); ?>">
                            <input type="hidden" name="comment" value="<?php echo htmlspecialchars($message['comment']); ?>">
                            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($message['id_user']); ?>">
                            <input type="hidden" name="id_place" value="<?php echo htmlspecialchars($message['id_place']); ?>">
                            <input type="hidden" name="id_service" value="<?php echo htmlspecialchars($message['id_service']); ?>">
                            <button type="submit" name="edit_message" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_message" value="<?php echo htmlspecialchars($message['id_message']); ?>">
                            <button type="submit" name="delete_message" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div class="add">
        <!-- Форма для добавления сервиса -->
        <h3>Добавить сервис</h3>
        <form action="" class="add__form" method="POST">
            <input type="text" class="add__input" name="title" placeholder="Название сервиса" required><br>
            <input type="number" class="add__input" name="price" placeholder="Цена" required><br>
            <textarea name="description" class="add__input" placeholder="Описание" required></textarea><br>
            <button type="submit" class="add__button" name="add_service">Добавить сервис</button>
        </form>

        <?php if (isset($_POST['edit_service'])): ?>
            <?php
            $id_service = $_POST['id_service'];
            $title = $_POST['title'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            ?>
            <h3>Изменить сервис</h3>
            <form action="" method="POST" class="change__form">
                <input type="hidden" class="change__input" name="id_service" value="<?php echo htmlspecialchars($id_service); ?>">
                <input type="text" class="change__input" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br>
                <input type="number" class="change__input" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br>
                <textarea name="description" class="change__input" required><?php echo htmlspecialchars($description); ?></textarea><br>
                <button type="submit" class="change__button" name="update_service">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>
    <h2>Управление сервисами</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Название</th>
                <th class="table__header-cell">Цена</th>
                <th class="table__header-cell">Описание</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($services as $service): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($service['id_service']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($service['title']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($service['price']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($service['description']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_service" value="<?php echo htmlspecialchars($service['id_service']); ?>">
                            <input type="hidden" name="title" value="<?php echo htmlspecialchars($service['title']); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($service['price']); ?>">
                            <input type="hidden" name="description" value="<?php echo htmlspecialchars($service['description']); ?>">
                            <button type="submit" name="edit_service" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_service" value="<?php echo htmlspecialchars($service['id_service']); ?>">
                            <button type="submit" name="delete_service" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="add">
        <h3>Добавить сообщение</h3>
        <form action="" class="add__form" method="POST">
            <input type="email"  class="add__input" name="email" placeholder="Email" required><br>
            <input type="text" class="add__input" name="name" placeholder="Имя" required><br>
            <textarea name="comment" class="add__input" placeholder="Комментарий" required></textarea><br>
            <input type="number" class="add__input" name="id_user" placeholder="ID пользователя" required><br>
            <button type="submit" class="add__button" name="add_connection">Добавить сообщение</button>
        </form>

        <?php if (isset($_POST['edit_connection'])): ?>
            <?php
            $id = $_POST['id_connection'];
            $email = $_POST['email'];
            $name = $_POST['name'];
            $comment = $_POST['comment'];
            $id_user = $_POST['id_user'];
            ?>
            <h3>Изменить сообщение</h3>
            <form action="" method="POST" class="change__form">
                <input type="hidden" class="change__input" name="id_connection" value="<?php echo htmlspecialchars($id); ?>">
                <input type="email" class="change__input" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <input type="text" class="change__input" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
                <textarea name="comment" class="change__input" required><?php echo htmlspecialchars($comment); ?></textarea><br>
                <input type="number" class="change__input" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" required><br>
                <button type="submit" class="change__button" name="update_connection">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>

    <h2>Управление обратной связью</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Email</th>
                <th class="table__header-cell">Имя</th>
                <th class="table__header-cell">Комментарий</th>
                <th class="table__header-cell">ID пользователя</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($connections as $connection): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($connection['id_connection']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($connection['email']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($connection['name']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($connection['comment']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($connection['id_user']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_connection" value="<?php echo htmlspecialchars($connection['id_connection']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($connection['email']); ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($connection['name']); ?>">
                            <input type="hidden" name="comment" value="<?php echo htmlspecialchars($connection['comment']); ?>">
                            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($connection['id_user']); ?>">
                            <button type="submit" name="edit_connection" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_connection" value="<?php echo htmlspecialchars($connection['id_connection']); ?>">
                            <button type="submit" name="delete_connection" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="add">
        <h3>Добавить корзину</h3>
        <form action="" class="add__form" method="POST">
            <input type="text" class="add__input" name="status" placeholder="Статус" required><br>
            <input type="number" class="add__input" name="id_user" placeholder="ID пользователя" required><br>
            <input type="number" class="add__input" name="id_product" placeholder="ID товара" required><br>
            <button type="submit" class="add__button" name="add_cart">Добавить корзину</button>
        </form>

        <?php if (isset($_POST['edit_cart'])): ?>
            <?php
            $id = $_POST['id_cart'];
            $status = $_POST['status'];
            $id_user = $_POST['id_user'];
            $id_product = $_POST['id_product'];
            ?>
            <h3>Изменить корзину</h3>
            <form action="" method="POST" class="change__form">
                <input type="hidden" class="change__input" name="id_cart" value="<?php echo htmlspecialchars($id); ?>">
                <input type="text" class="change__input" name="status" value="<?php echo htmlspecialchars($status); ?>" required><br>
                <input type="number" class="change__input" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>" required><br>
                <input type="number" class="change__input" name="id_product" value="<?php echo htmlspecialchars($id_product); ?>" required><br>
                <button type="submit" class="change__button" name="update_cart">Сохранить изменения</button>
            </form>
        <?php endif; ?>
    </div>

    <h2>Управление корзинами</h2>
    <table class="table">
        <thead class="table__header">
            <tr>
                <th class="table__header-cell">ID</th>
                <th class="table__header-cell">Статус</th>
                <th class="table__header-cell">ID пользователя</th>
                <th class="table__header-cell">ID товара</th>
                <th class="table__header-cell">Действия</th>
            </tr>
        </thead>
        <tbody class="table__body">
            <?php foreach ($carts as $cart): ?>
                <tr class="table__row">
                    <td class="table__cell"><?php echo htmlspecialchars($cart['id_cart']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($cart['status']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($cart['id_user']); ?></td>
                    <td class="table__cell"><?php echo htmlspecialchars($cart['id_product']); ?></td>
                    <td class="table__cell table__actions">
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_cart" value="<?php echo htmlspecialchars($cart['id_cart']); ?>">
                            <input type="hidden" name="status" value="<?php echo htmlspecialchars($cart['status']); ?>">
                            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($cart['id_user']); ?>">
                            <input type="hidden" name="id_product" value="<?php echo htmlspecialchars($cart['id_product']); ?>">
                            <button type="submit" name="edit_cart" class="table__button table__button--edit">Изменить</button>
                        </form>
                        <form action="" method="POST" class="table__form">
                            <input type="hidden" name="id_cart" value="<?php echo htmlspecialchars($cart['id_cart']); ?>">
                            <button type="submit" name="delete_cart" class="table__button table__button--delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>
