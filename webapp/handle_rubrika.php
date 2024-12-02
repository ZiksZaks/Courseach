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
    if (!empty($_POST['nazv_rubrika']) && !empty($_POST['kol_rubrika'])) {
        addRecord($_POST['nazv_rubrika'], $_POST['kol_rubrika']);
    } elseif (!empty($_POST['old_nazv_rubrika']) && !empty($_POST['new_nazv_rubrika']) && !empty($_POST['new_kol_rubrika'])) {
        updateRecord($_POST['old_nazv_rubrika'], $_POST['new_nazv_rubrika'], $_POST['new_kol_rubrika']);
    } elseif (!empty($_POST['del_nazv_rubrika'])) {
        deleteRecord($_POST['del_nazv_rubrika']);
    }
}

function addRecord($nazv_rubrika, $kol_rubrika)
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO rubrika (nazv_rubrika, kol_rubrika) VALUES (?, ?)");
    $stmt->execute([$nazv_rubrika, $kol_rubrika]);
}

function updateRecord($old_nazv_rubrika, $new_nazv_rubrika, $new_kol_rubrika)
{
    global $pdo;

    $stmt = $pdo->prepare("UPDATE rubrika SET nazv_rubrika = ?, kol_rubrika = ? WHERE nazv_rubrika = ?");
    $stmt->execute([$new_nazv_rubrika, $new_kol_rubrika, $old_nazv_rubrika]);
    
}

function deleteRecord($del_nazv_rubrika)
{
    global $pdo;
    try {
    $stmt = $pdo->prepare("DELETE FROM rubrika WHERE nazv_rubrika = ?");
    $stmt->execute([$del_nazv_rubrika]);
    return true;
    } catch (PDOException $e) {
        return false; // Возвращает false в случае ошибки при удалении
    }
}

header('Location: rubrika.php');
?>
