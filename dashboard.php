<?php
session_start();
require_once 'config/db.php';

// Получение данных для общих метрик
$result_users = $conn->query("SELECT COUNT(*) AS total_users FROM user");
$total_users = $result_users->fetch_assoc()['total_users'];

$result_products = $conn->query("SELECT COUNT(*) AS total_products FROM product");
$total_products = $result_products->fetch_assoc()['total_products'];

$result_orders = $conn->query("SELECT COUNT(*) AS total_orders FROM cart");
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Общее количество заявок
$result_total_requests = $conn->query("SELECT COUNT(*) AS total_requests FROM connection");
$total_requests = $result_total_requests->fetch_assoc()['total_requests'];


// Данные для круговой диаграммы
$result_chart = $conn->query("SELECT type, COUNT(*) AS count FROM product GROUP BY type");
$chart_data = [];
while ($row = $result_chart->fetch_assoc()) {
    $chart_data[] = $row;
}

// Данные для изменения количества заказов с течением времени
$result_orders_time = $conn->query("SELECT DATE(created_at) AS order_date, COUNT(*) AS order_count FROM cart GROUP BY DATE(created_at) ORDER BY order_date");
$orders_time_data = [];
while ($row = $result_orders_time->fetch_assoc()) {
    $orders_time_data[] = $row;
}

// Данные для популярных товаров
$result_popular = $conn->query("
    SELECT p.title AS product_name, p.type AS product_type, COUNT(c.id_product) AS total_orders 
    FROM cart AS c 
    JOIN product AS p ON c.id_product = p.id_product 
    GROUP BY c.id_product 
    ORDER BY total_orders DESC 
    LIMIT 10
");
$popular_products = [];
while ($row = $result_popular->fetch_assoc()) {
    $popular_products[] = $row;
}

$result_payment_status = $conn->query("SELECT status, COUNT(*) AS count FROM cart GROUP BY status");
$payment_status_data = [];
while ($row = $result_payment_status->fetch_assoc()) {
    $payment_status_data[] = $row;
}


// Данные по заявкам от клиентов по дням
$result_requests_time = $conn->query("
    SELECT DATE(created_at) AS request_date, COUNT(*) AS request_count 
    FROM connection 
    GROUP BY DATE(created_at) 
    ORDER BY request_date
");
$requests_time_data = [];
while ($row = $result_requests_time->fetch_assoc()) {
    $requests_time_data[] = $row;
}

// Пиковые дни заказов по дням недели
$result_orders_weekday = $conn->query("
    SELECT DAYNAME(created_at) AS weekday, COUNT(*) AS count 
    FROM cart 
    GROUP BY weekday
");

$orders_weekday_data = [];
while ($row = $result_orders_weekday->fetch_assoc()) {
    $orders_weekday_data[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jost:wght@400;500;700&display=swap');

        /* Общие стили */
        body.dashboard-body {
            font-family: 'Jost', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            text-align: center;
        }

        h1.dashboard-title {
            margin: 20px 0;
            font-size: 3rem;
            font-weight: 700;
        }

        .section-heading {
            font-size: 2rem;
            margin: 20px 0;
            font-weight: 500;
        }

        .metrics-section p {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .chart-container {
            width: 80%;
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .table-section {
            margin: 20px auto;
            width: 80%;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .styled-table th, .styled-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .styled-table th {
            background-color: #7c28e3;
            color: #fff;
            font-weight: bold;
        }

        .styled-table tr:nth-child(even) {
            background-color: #f3f3f3;
        }

        .styled-table tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s;
        }

        .btn__request-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #617EE4;
            color: #f9f9f9;
            text-align: center;
            text-decoration: none;
        }

        .btn__request-link:hover {
            background-color: #f9f9f9;
            color: #617EE4;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Подключение Chart.js -->
    <title>Dashboard</title>
</head>
<body class="dashboard-body">
    <div class="btn__request">
        <a href="admin.php" class="btn__request-link">Вернуться назад</a>
    </div>
    <h1 class="dashboard-title">Dashboard</h1>

    <section class="metrics-section">
        <h2 class="section-heading">Общие метрики</h2>
        <p>Общее количество пользователей: <span><?php echo $total_users; ?></span></p>
        <p>Количество товаров: <span><?php echo $total_products; ?></span></p>
        <p>Количество заказов: <span><?php echo $total_orders; ?></span></p>
        <p>Количество заявок от клиентов: <span><?php echo $total_requests; ?></span></p>
    </section>

    <section class="chart-section">
        <h2 class="section-heading">Типы товаров</h2>
        <div class="chart-container">
            <canvas id="productChart"></canvas>
        </div>
    </section>

    <section class="chart-section">
        <h2 class="section-heading">Изменение количества заказов с течением времени</h2>
        <div class="chart-container">
            <canvas id="orderChart"></canvas>
        </div>
    </section>

    <section class="table-section">
        <h2 class="section-heading">Таблица популярных товаров</h2>
        <table class="styled-table">
            <tr>
                <th>Название товара</th>
                <th>Категория</th>
                <th>Количество заказов</th>
            </tr>
            <?php foreach ($popular_products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($product['product_type']); ?></td>
                    <td><?php echo htmlspecialchars($product['total_orders']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <section class="chart-section">
        <h2 class="section-heading">Оплачено / Не оплачено</h2>
        <div class="chart-container">
            <canvas id="paymentChart"></canvas>
        </div>
    </section>

    <section class="chart-section">
        <h2 class="section-heading">Заявки от клиентов по дням</h2>
        <div class="chart-container">
            <canvas id="requestChart"></canvas>
        </div>
    </section>

    <section class="chart-section">
        <h2 class="section-heading">Пиковые дни заказов</h2>
        <div class="chart-container">
            <canvas id="weekdayChart"></canvas>
        </div>
    </section>



    <script>
        const productCtx = document.getElementById('productChart').getContext('2d');
        const productData = {
            labels: <?php echo json_encode(array_column($chart_data, 'type')); ?>,
            datasets: [{
                label: 'Типы товаров',
                data: <?php echo json_encode(array_column($chart_data, 'count')); ?>,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        };
        new Chart(productCtx, { type: 'pie', data: productData });

        const orderCtx = document.getElementById('orderChart').getContext('2d');
        const orderData = {
            labels: <?php echo json_encode(array_column($orders_time_data, 'order_date')); ?>,
            datasets: [{
                label: 'Количество заказов',
                data: <?php echo json_encode(array_column($orders_time_data, 'order_count')); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true
            }]
        };
        new Chart(orderCtx, { type: 'line', data: orderData });

        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        const paymentData = {
            labels: <?php echo json_encode(array_column($payment_status_data, 'status')); ?>,
            datasets: [{
                label: 'Статус оплаты',
                data: <?php echo json_encode(array_column($payment_status_data, 'count')); ?>,
                backgroundColor: ['#4CAF50', '#FF5252'] // можно настроить цвета под стиль
            }]
        };
        new Chart(paymentCtx, { type: 'pie', data: paymentData });

        const requestCtx = document.getElementById('requestChart').getContext('2d');
        const requestData = {
            labels: <?php echo json_encode(array_column($requests_time_data, 'request_date')); ?>,
            datasets: [{
                label: 'Количество заявок',
                data: <?php echo json_encode(array_column($requests_time_data, 'request_count')); ?>,
                borderColor: '#7C28E3',
                backgroundColor: 'rgba(124, 40, 227, 0.2)',
                fill: true
            }]
        };
        new Chart(requestCtx, { type: 'line', data: requestData });

        const weekdayCtx = document.getElementById('weekdayChart').getContext('2d');
        const weekdayData = {
            labels: <?php echo json_encode(array_column($orders_weekday_data, 'weekday')); ?>,
            datasets: [{
                label: 'Количество заказов',
                data: <?php echo json_encode(array_column($orders_weekday_data, 'count')); ?>,
                backgroundColor: '#FFCE56',
                borderColor: '#FFA500',
                borderWidth: 1
            }]
        };
        new Chart(weekdayCtx, {
            type: 'bar',
            data: weekdayData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
</body>
</html>
