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
    if (!empty($_POST['familia']) && !empty($_POST['ima']) && !empty($_POST['gorod_proziv']) && !empty($_POST['ylicha_proziv']) && !empty($_POST['dom_proziv']) && !empty($_POST['nomer_telefon'])) {
        addRecord($_POST['familia'], $_POST['ima'], $_POST['otchestvo'], $_POST['gorod_proziv'], $_POST['ylicha_proziv'], $_POST['dom_proziv'], $_POST['nomer_telefon']);
    }


    if (!empty($_POST['familia_upd']) && !empty($_POST['ima_upd']) && !empty($_POST['otchestvo_upd']) && !empty($_POST['new_familia']) && !empty($_POST['new_ima']) && !empty($_POST['new_otchestvo']) && !empty($_POST['new_gorod_proziv']) && !empty($_POST['new_ylicha_proziv']) && !empty($_POST['new_dom_proziv']) && !empty($_POST['new_nomer_telefon'])) {
        updateRecord($_POST['familia_upd'], $_POST['ima_upd'], $_POST['otchestvo_upd'], $_POST['new_familia'], $_POST['new_ima'], $_POST['new_otchestvo'], $_POST['new_gorod_proziv'], $_POST['new_ylicha_proziv'], $_POST['new_dom_proziv'], $_POST['new_nomer_telefon']);
    }
    

    if (!empty($_POST['familia_del']) && !empty($_POST['ima_del']) && !empty($_POST['otchestvo_del'])) {
        deleteRecord($_POST['familia_del'], $_POST['ima_del'], $_POST['otchestvo_del']);
    }    
}

function addRecord($familia, $ima, $otchestvo, $gorod_proziv, $ylicha_proziv, $dom_proziv, $nomer_telefon)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT telefon_cod FROM gorod WHERE nazvanie_gorod = ?");
    $stmt->execute([$gorod_proziv]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $telefon_cod = $result['telefon_cod'];
        $stmt = $pdo->prepare("INSERT INTO fiz_licho (familia, ima, otchestvo, gorod_proziv, ylicha_proziv, dom_proziv, nomer_telefon, telefon_cod) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$familia, $ima, $otchestvo, $gorod_proziv, $ylicha_proziv, $dom_proziv, $nomer_telefon, $telefon_cod]);
    } else {
        echo "Такого города нет в базе данных.";
    }
}

function updateRecord($familia_upd, $ima_upd, $otchestvo_upd, $new_familia, $new_ima, $new_otchestvo, $new_gorod_proziv, $new_ylicha_proziv, $new_dom_proziv, $new_nomer_telefon)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE fiz_licho SET familia = ?, ima = ?, otchestvo = ?, gorod_proziv = ?, ylicha_proziv = ?, dom_proziv = ?, nomer_telefon = ? WHERE familia = ? AND ima = ? AND otchestvo = ?");
    $stmt->execute([$new_familia, $new_ima, $new_otchestvo, $new_gorod_proziv, $new_ylicha_proziv, $new_dom_proziv, $new_nomer_telefon, $familia_upd]);
}

function deleteRecord($familia, $ima, $otchestvo)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM fiz_licho WHERE familia = ? AND ima = ? AND otchestvo = ?");
    $stmt->execute([$familia, $ima, $otchestvo]);
}

header('Location: fiz_licho.php');
?>
