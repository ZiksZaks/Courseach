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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['familia']) && !empty($_POST['nomer_telefon'])) {
        searchPerson($_POST['familia'], $_POST['nomer_telefon']);
    }
}

function searchPerson($familia, $nomer_telefon)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM fiz_licho WHERE familia = ? AND nomer_telefon = ?");
    $stmt->execute([$familia, $nomer_telefon]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "<h2 class='form-h2'>Результат поиска</h2>";
        echo "<table border='1'>
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Город проживания</th>
                <th>Улица проживания</th>
                <th>Дом проживания</th>
                <th>Номер телефона</th>
                <th>Телефонный код</th>
            </tr>";
        echo "<tr>";
        echo "<td>" . $result['familia'] . "</td>";
        echo "<td>" . $result['ima'] . "</td>";
        echo "<td>" . $result['otchestvo'] . "</td>";
        echo "<td>" . $result['gorod_proziv'] . "</td>";
        echo "<td>" . $result['ylicha_proziv'] . "</td>";
        echo "<td>" . $result['dom_proziv'] . "</td>";
        echo "<td>" . $result['nomer_telefon'] . "</td>";
        echo "<td>" . $result['telefon_cod'] . "</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "Физ. лицо не найдено";
    }
}

?>
