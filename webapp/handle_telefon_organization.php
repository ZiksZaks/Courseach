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
    if (!empty($_POST['nomer_telefon']) && !empty($_POST['nazv_organization'])) {
        addRecord($_POST['nomer_telefon'], $_POST['nazv_organization']);
    } elseif (!empty($_POST['old_nomer_telefon']) && !empty($_POST['old_nazv_organization']) && !empty($_POST['new_nomer_telefon'])) {
        updateRecord($_POST['old_nomer_telefon'], $_POST['old_nazv_organization'], $_POST['new_nomer_telefon']);
    } elseif (!empty($_POST['del_nomer_telefon']) && !empty($_POST['del_nazv_organization'])) {
        deleteRecord($_POST['del_nomer_telefon'], $_POST['del_nazv_organization']);
    }
}

function addRecord($nomer_telefon, $nazv_organization)
{
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO telefon_organization (nomer_telefon, nazv_organization) VALUES (?, ?)");
    $stmt->execute([$nomer_telefon, $nazv_organization]);
}

function updateRecord($old_nomer_telefon, $old_nazv_organization, $new_nomer_telefon)
{
    global $pdo;

    $stmt = $pdo->prepare("UPDATE telefon_organization SET nomer_telefon = ? WHERE nomer_telefon = ? AND nazv_organization = ?");
    $stmt->execute([$new_nomer_telefon, $old_nomer_telefon, $old_nazv_organization]);
}

function deleteRecord($del_nomer_telefon, $del_nazv_organization)
{
    global $pdo;

    $stmt = $pdo->prepare("DELETE FROM telefon_organization WHERE nomer_telefon = ? AND nazv_organization = ?");
    $stmt->execute([$del_nomer_telefon, $del_nazv_organization]);
}

header('Location: telefon_organization.php');
?>
