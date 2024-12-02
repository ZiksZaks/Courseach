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
    if (!empty($_POST['nazv_organization']) && !empty($_POST['gorod_organization']) && !empty($_POST['ylicha_organization']) && !empty($_POST['dom_organization']) && !empty($_POST['nazv_rubrika'])) {
        addRecord($_POST['nazv_organization'], $_POST['gorod_organization'], $_POST['ylicha_organization'], $_POST['dom_organization'], $_POST['nazv_rubrika']);
    } elseif (!empty($_POST['nazv_organization']) && !empty($_POST['gorod_organization']) && !empty($_POST['nazv_organization_upd']) && !empty($_POST['gorod_organization_upd']) && !empty($_POST['ylicha_organization_upd']) && !empty($_POST['dom_organization_upd']) && !empty($_POST['nazv_rubrika_upd'])) {
        updateRecord($_POST['nazv_organization'], $_POST['gorod_organization'], $_POST['nazv_organization_upd'], $_POST['gorod_organization_upd'], $_POST['ylicha_organization_upd'], $_POST['dom_organization_upd'], $_POST['nazv_rubrika_upd']);
    } elseif (!empty($_POST['nazv_organization_del']) && !empty($_POST['gorod_organization_del']) && !empty($_POST['ylicha_organization_del']) && !empty($_POST['dom_organization_del'])) {
        deleteRecord($_POST['nazv_organization_del'], $_POST['gorod_organization_del'], $_POST['ylicha_organization_del'], $_POST['dom_organization_del']);
    }
}

function addRecord($nazv_organization, $gorod_organization, $ylicha_organization, $dom_organization, $nazv_rubrika)
{
    global $pdo;

    $telefon_cod = getTelefonCod($gorod_organization);

    $stmt = $pdo->prepare("INSERT INTO organization (nazv_organization, gorod_organization, ylicha_organization, dom_organization, telefon_cod, nazv_rubrika) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nazv_organization, $gorod_organization, $ylicha_organization, $dom_organization, $telefon_cod, $nazv_rubrika]);
}

function updateRecord($old_nazv_organization, $old_gorod_organization, $new_nazv_organization, $new_gorod_organization, $new_ylicha_organization, $new_dom_organization, $new_nazv_rubrika)
{
    global $pdo;

    $telefon_cod = getTelefonCod($new_gorod_organization);

    $stmt = $pdo->prepare("UPDATE organization SET nazv_organization = ?, gorod_organization = ?, ylicha_organization = ?, dom_organization = ?, telefon_cod = ?, nazv_rubrika = ? WHERE nazv_organization = ? AND gorod_organization = ? AND ylicha_organization = ? AND dom_organization = ?");
    $stmt->execute([$new_nazv_organization, $new_gorod_organization, $new_ylicha_organization, $new_dom_organization, $telefon_cod, $new_nazv_rubrika, $old_nazv_organization, $old_gorod_organization, $_POST['ylicha_organization_upd'], $_POST['dom_organization_upd']]);
}

function deleteRecord($del_nazv_organization, $del_gorod_organization, $del_ylicha_organization, $del_dom_organization)
{
    global $pdo;
    try {
    $stmt = $pdo->prepare("DELETE FROM organization WHERE nazv_organization = ? AND gorod_organization = ? AND ylicha_organization = ? AND dom_organization = ?");
    $stmt->execute([$del_nazv_organization, $del_gorod_organization, $del_ylicha_organization, $del_dom_organization]);
    return true;
    } catch (PDOException $e) {
        return false; // Возвращает false в случае ошибки при удалении
    }
}

function getTelefonCod($gorod_organization)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT telefon_cod FROM gorod WHERE nazvanie_gorod = ?");
    $stmt->execute([$gorod_organization]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($result) ? $result['telefon_cod'] : '';
}

header('Location: organization.php');
?>
