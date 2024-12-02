<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление таблицей telefon_organization</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .telefon-organization-table {
            margin-top: 60px;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }
        .forms-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .forms-container > div {
            width: 350px;
            margin-left: 60px;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        form label {
            margin-bottom: 5px;
        }
        form input[type="text"],
        form input[type="number"],
        form input[type="submit"],
        form select {
            padding: 5px;
            margin-bottom: 5px;
        }
        .form-h2 {
            color: black;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Таблица telefon_organization</h2>
    </div>
        
    <!-- Вывод таблицы telefon_organization -->
    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM telefon_organization");
        echo "<table border='1' class='telefon-organization-table'>
            <tr>
                <th>Номер телефона</th>
                <th>Название организации</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nomer_telefon'] . "</td>";
            echo "<td>" . $row['nazv_organization'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        die("Ошибка при получении данных: " . $e->getMessage());
    }
    ?>

    <div class="forms-container">
        <div>
            <h2 class='form-h2'>Добавить запись в таблицу</h2>
            <form action="handle_telefon_organization.php" method="post">
                <label for="nomer_telefon">Номер телефона:</label>
                <input type="number" id="nomer_telefon" name="nomer_telefon"><br><br>
                <label for="nazv_organization">Название организации:</label>
                <select id="nazv_organization" name="nazv_organization">
                    <?php

                    try {
                        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $stmt = $pdo->query("SELECT nazv_organization FROM organization");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazv_organization'] . "'>" . $row['nazv_organization'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка при получении данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <input type="submit" value="Добавить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Изменить запись в таблице</h2>
            <form action="handle_telefon_organization.php" method="post">
                <label for="old_nomer_telefon">Старый номер телефона:</label>
                <input type="number" id="old_nomer_telefon" name="old_nomer_telefon"><br><br>
                <label for="old_nazv_organization">Какой организации принадлежит номер:</label>
                <select id="old_nazv_organization" name="old_nazv_organization">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT nazv_organization FROM organization");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazv_organization'] . "'>" . $row['nazv_organization'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка при получении данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <label for="new_nomer_telefon">Новый номер телефона:</label>
                <input type="number" id="new_nomer_telefon" name="new_nomer_telefon"><br><br>
                <input type="submit" value="Изменить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Удалить запись из таблицы</h2>
            <form action="handle_telefon_organization.php" method="post">
                <label for="del_nomer_telefon">Номер телефона:</label>
                <input type="number" id="del_nomer_telefon" name="del_nomer_telefon"><br><br>
                <label for="del_nazv_organization">Название организации:</label>
                <select id="del_nazv_organization" name="del_nazv_organization">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT nazv_organization FROM organization");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazv_organization'] . "'>" . $row['nazv_organization'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка при получении данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <input type="submit" value="Удалить запись">
            </form>
        </div>
    </div>
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
