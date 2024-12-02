<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление таблицей Organization</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .organization-table {
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
        <h2>Таблица Organization</h2>
    </div>

    <!-- Вывод таблицы organization -->
    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT * FROM organization");
        echo "<table border='1' class='organization-table'>
            <tr>
                <th>Название организации</th>
                <th>Город</th>
                <th>Улица</th>
                <th>Дом</th>
                <th>Телефонный код</th>
                <th>Название рубрики</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nazv_organization'] . "</td>";
            echo "<td>" . $row['gorod_organization'] . "</td>";
            echo "<td>" . $row['ylicha_organization'] . "</td>";
            echo "<td>" . $row['dom_organization'] . "</td>";
            echo "<td>" . $row['telefon_cod'] . "</td>";
            echo "<td>" . $row['nazv_rubrika'] . "</td>";
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
            <form action="handle_organization.php" method="post">
                <label for="nazv_organization">Название организации:</label>
                <input type="text" id="nazv_organization" name="nazv_organization"><br><br>
                <label for="gorod_organization">Город:</label>
                <select id="gorod_organization" name="gorod_organization">
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
                <label for="ylicha_organization">Улица:</label>
                <input type="text" id="ylicha_organization" name="ylicha_organization"><br><br>
                <label for="dom_organization">Дом:</label>
                <input type="number" id="dom_organization" name="dom_organization"><br><br>
                <label for="nazv_rubrika">Название рубрики:</label>
                <select id="nazv_rubrika" name="nazv_rubrika">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT nazv_rubrika FROM rubrika");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazv_rubrika'] . "'>" . $row['nazv_rubrika'] . "</option>";
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
            <form action="handle_organization.php" method="post">
                <label for="nazv_organization">Старое название организации:</label>
                <input type="text" id="nazv_organization" name="nazv_organization"><br><br>
                <label for="gorod_organization">Старый город:</label>
                <select id="gorod_organization" name="gorod_organization">
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
                <label for="ylicha_organization_upd">Старая улица:</label>
                <input type="text" id="ylicha_organization_upd" name="ylicha_organization_upd"><br><br>
                <label for="dom_organization_upd">Старый дом:</label>
                <input type="number" id="dom_organization_upd" name="dom_organization_upd"><br><br>
                <label for="nazv_organization_upd">Новое название организации:</label>
                <input type="text" id="nazv_organization_upd" name="nazv_organization_upd"><br><br>
                <label for="gorod_organization_upd">Новый город:</label>
                <input type="text" id="gorod_organization_upd" name="gorod_organization_upd"><br><br>
                <label for="ylicha_organization_upd">Новая улица:</label>
                <input type="text" id="ylicha_organization_upd" name="ylicha_organization_upd"><br><br>
                <label for="dom_organization_upd">Новый дом:</label>
                <input type="number" id="dom_organization_upd" name="dom_organization_upd"><br><br>
                <label for="nazv_rubrika_upd">Новое название рубрики:</label>
                <select id="nazv_rubrika_upd" name="nazv_rubrika_upd">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT nazv_rubrika FROM rubrika");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['nazv_rubrika'] . "'>" . $row['nazv_rubrika'] . "</option>";
                        }
                    } catch (PDOException $e) {
                        die("Ошибка при получении данных: " . $e->getMessage());
                    }
                    ?>
                </select><br><br>
                <input type="submit" value="Изменить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Удалить запись из таблицы</h2>
            <form action="handle_organization.php" method="post">
                <label for="nazv_organization_del">Название организации:</label>
                <input type="text" id="nazv_organization_del" name="nazv_organization_del"><br><br>
                <label for="gorod_organization_del">Город организации:</label>
                <select id="gorod_organization_del" name="gorod_organization_del">
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
                <label for="ylicha_organization_del">Улица организации:</label>
                <input type="text" id="ylicha_organization_del" name="ylicha_organization_del"><br><br>
                <label for="dom_organization_del">Дом организации:</label>
                <input type="number" id="dom_organization_del" name="dom_organization_del"><br><br>
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
