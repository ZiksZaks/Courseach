<?php
$host = 'localhost';
$dbname = 'Kyrsovik';
$username = 'postgres';
$password = 'superuser';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Обработка формы поиска
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nazv_rubrika']) && !empty($_POST['gorod_organization'])) {
        searchReport($_POST['nazv_rubrika'], $_POST['gorod_organization']);
    }
}

// Функция поиска отчёта
function searchReport($nazv_rubrika, $gorod_organization)
{
    global $pdo;

    // Вызов функции report_by_rubric_and_city
    $stmt = $pdo->prepare("SELECT * FROM report_by_rubric_and_city(:nazv_rubrika, :gorod_organization)");
    $stmt->bindParam(':nazv_rubrika', $nazv_rubrika, PDO::PARAM_STR);
    $stmt->bindParam(':gorod_organization', $gorod_organization, PDO::PARAM_STR);
    $stmt->execute();

    // Вывод результата отчёта с измененным порядком столбцов
    echo "<h2>Результат отчёта</h2>";
    echo "<table border='1'>
        <tr>
            <th>Название организации</th>
            <th>Название рубрики</th>
            <th>Город</th>
            <th>Улица</th>
            <th>Дом</th>
            <th>Номер телефона</th>
        </tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['nazv_organization'] . "</td>";
        echo "<td>" . $row['nazv_rubrika'] . "</td>";
        echo "<td>" . $row['gorod_organization'] . "</td>";
        echo "<td>" . $row['ylicha_organization'] . "</td>";
        echo "<td>" . $row['dom_organization'] . "</td>";
        echo "<td>" . $row['nomer_telefon'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
