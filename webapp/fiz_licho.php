<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление таблицей Fiz_licho</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .fiz-licho-table {
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
        <h2>Таблица Fiz_licho</h2>
    </div>
        
    <!-- Вывод таблицы fiz_licho -->
    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $pdo->query("SELECT * FROM fiz_licho ORDER BY familia");
        echo "<table border='1' class='fiz-licho-table'>
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Город проживания</th>
                <th>Улица проживания</th>
                <th>Дом проживания</th>
                <th>Номер телефона</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['familia'] . "</td>";
            echo "<td>" . $row['ima'] . "</td>";
            echo "<td>" . $row['otchestvo'] . "</td>";
            echo "<td>" . $row['gorod_proziv'] . "</td>";
            echo "<td>" . $row['ylicha_proziv'] . "</td>";
            echo "<td>" . $row['dom_proziv'] . "</td>";
            echo "<td>" . $row['nomer_telefon'] . "</td>";
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
            <form action="handle_fiz_licho.php" method="post">
                <label for="familia">Фамилия:</label>
                <input type="text" id="familia" name="familia"><br><br>
                <label for="ima">Имя:</label>
                <input type="text" id="ima" name="ima"><br><br>
                <label for="otchestvo">Отчество:</label>
                <input type="text" id="otchestvo" name="otchestvo"><br><br>
                <label for="gorod_proziv">Город проживания:</label>
                <select id="gorod_proziv" name="gorod_proziv">
                    <?php

                    try {
                        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
                        $stmt = $pdo->query("SELECT nazvanie_gorod FROM gorod");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazvanie_gorod'] . "'>" . $row['nazvanie_gorod'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка подключения к базе данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <label for="ylicha_proziv">Улица проживания:</label>
                <input type="text" id="ylicha_proziv" name="ylicha_proziv"><br><br>
                <label for="dom_proziv">Дом проживания:</label>
                <input type="number" id="dom_proziv" name="dom_proziv"><br><br>
                <label for="nomer_telefon">Номер телефона:</label>
                <input type="text" id="nomer_telefon" name="nomer_telefon"><br><br>
                <input type="submit" value="Добавить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Изменить запись в таблице</h2>
            <form action="handle_fiz_licho.php" method="post">
                <label for="familia_upd">Фамилия:</label>
                <input type="text" id="familia_upd" name="familia_upd"><br><br>
                <label for="ima_upd">Имя:</label>
                <input type="text" id="ima_upd" name="ima_upd"><br><br>
                <label for="otchestvo_upd">Отчество:</label>
                <input type="text" id="otchestvo_upd" name="otchestvo_upd"><br><br>
                <label for="new_familia">Новая фамилия:</label>
                <input type="text" id="new_familia" name="new_familia"><br><br>
                <label for="new_ima">Новое имя:</label>
                <input type="text" id="new_ima" name="new_ima"><br><br>
                <label for="new_otchestvo">Новое отчество:</label>
                <input type="text" id="new_otchestvo" name="new_otchestvo"><br><br>
                <label for="new_gorod_proziv">Новый город проживания:</label>
                <select id="new_gorod_proziv" name="new_gorod_proziv">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT nazvanie_gorod FROM gorod");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazvanie_gorod'] . "'>" . $row['nazvanie_gorod'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка при получении данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <label for="new_ylicha_proziv">Новая улица проживания:</label>
                <input type="text" id="new_ylicha_proziv" name="new_ylicha_proziv"><br><br>
                <label for="new_dom_proziv">Новый дом проживания:</label>
                <input type="number" id="new_dom_proziv" name="new_dom_proziv"><br><br>
                <label for="new_nomer_telefon">Новый номер телефона:</label>
                <input type="text" id="new_nomer_telefon" name="new_nomer_telefon"><br><br>
                <input type="submit" value="Изменить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Удалить запись из таблицы</h2>
            <form action="handle_fiz_licho.php" method="post">
                <label for="familia_del">Фамилия:</label>
                <input type="text" id="familia_del" name="familia_del"><br><br>
                <label for="ima_del">Имя:</label>
                <input type="text" id="ima_del" name="ima_del"><br><br>
                <label for="otchestvo_del">Отчество:</label>
                <input type="text" id="otchestvo_del" name="otchestvo_del"><br><br>
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
