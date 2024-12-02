<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отчет по городу и рубрике</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .report-table {
            margin-top: 60px;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }
        .print-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Отчет по городам и рубрикам</h2>
    </div>

    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM public.report_by_city_and_rubric");
        echo "<table border='1' class='report-table'>
            <tr>
                <th>Название рубрики</th>
                <th>Город</th>
                <th>Название организации</th>
                <th>Номер телефона</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nazv_rubrika'] . "</td>";
            echo "<td>" . $row['gorod_organization'] . "</td>";
            echo "<td>" . $row['nazv_organization'] . "</td>";
            echo "<td>" . $row['nomer_telefon'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        die("Ошибка при получении данных: " . $e->getMessage());
    }
    ?>
    <script>
        function printResults() {
            window.print(); // Используем встроенную функцию браузера для печати
        }
    </script>

    <button class="print-button" onclick="printResults()">Печать</button>

    <div class="sidebar">
        <table>
            <tr>
                <td><a href="login.php">Выход</a></td>
            </tr>
            <tr>
                <td><a href="main.php">На главную</a></td>
            </tr>
        </table>
    </div>
</body>
</html>
