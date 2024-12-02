<?php
$host = 'localhost';
$dbname = 'Kyrsovik';
$username = 'postgres';
$password = 'superuser';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['telefon_cod']) && !empty($_POST['nazvanie_gorod']) && !empty($_POST['strana'])) {
        addRecord($_POST['telefon_cod'], $_POST['nazvanie_gorod'], $_POST['strana']);
    }

    if (!empty($_POST['telefon_cod_upd']) && !empty($_POST['new_nazvanie_gorod']) && !empty($_POST['new_strana'])) {
        updateRecord($_POST['telefon_cod_upd'], $_POST['new_nazvanie_gorod'], $_POST['new_strana']);
    }

    if (!empty($_POST['telefon_cod_del'])) {
        deleteRecord($_POST['telefon_cod_del']);
    }
}

function addRecord($telefon_cod, $nazvanie_gorod, $strana)
{
    global $pdo;
    // Проверяем, начинается ли номер телефона с "+"
    if (strpos($telefon_cod, '+') !== 0) {
        // Возвращаем JSON с сообщением об ошибке
        echo json_encode(array("error" => "Телефонный код должен начинаться с '+'"));
        return; // Выходим из функции, не добавляя запись
    }

    $stmt = $pdo->prepare("INSERT INTO gorod (telefon_cod, nazvanie_gorod, strana) VALUES (?, ?, ?)");
    $stmt->execute([$telefon_cod, $nazvanie_gorod, $strana]);

    // Возвращаем JSON с сообщением об успешном добавлении
    echo json_encode(array("success" => "Запись успешно добавлена"));
}

function updateRecord($telefon_cod, $new_nazvanie_gorod, $new_strana)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE gorod SET nazvanie_gorod = ?, strana = ? WHERE telefon_cod = ?");
    $stmt->execute([$new_nazvanie_gorod, $new_strana, $telefon_cod]);
}

function deleteRecord($telefon_cod)
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM gorod WHERE telefon_cod = ?");
        $stmt->execute([$telefon_cod]);
        return true; // Возвращает true, если удаление прошло успешно
    } catch (PDOException $e) {
        return false; // Возвращает false в случае ошибки при удалении
    }
}

header('Location: gorod.php');
?>
