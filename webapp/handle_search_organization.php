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
    if (!empty($_POST['nazv_organization']) && !empty($_POST['nomer_telefon'])) {
        searchOrganization($_POST['nazv_organization'], $_POST['nomer_telefon']);
    }
}

// Функция поиска организации
function searchOrganization($nazv_organization, $nomer_telefon)
{
    global $pdo;

    // Вызов функции find_organization
    $stmt = $pdo->prepare("SELECT * FROM find_organization(:nazv_organization, :nomer_telefon)");
    $stmt->bindParam(':nazv_organization', $nazv_organization, PDO::PARAM_STR);
    $stmt->bindParam(':nomer_telefon', $nomer_telefon, PDO::PARAM_INT);
    $stmt->execute();

    // Вывод результата поиска
    echo "<h2 class='form-h2'>Результат поиска</h2>";
    echo "<table border='1'>
        <tr>
            <th>Название организации</th>
            <th>Номер телефона</th>
            <th>Город организации</th>
            <th>Улица организации</th>
            <th>Дом организации</th>
            <th>Телефонный код</th>
            <th>Рубрика</th>
        </tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['nazv_organization'] . "</td>";
        echo "<td>" . $row['nomer_telefon'] . "</td>";
        echo "<td>" . $row['gorod_organization'] . "</td>";
        echo "<td>" . $row['ylicha_organization'] . "</td>";
        echo "<td>" . $row['dom_organization'] . "</td>";
        echo "<td>" . $row['telefon_cod'] . "</td>";
        echo "<td>" . $row['nazv_rubrika'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
