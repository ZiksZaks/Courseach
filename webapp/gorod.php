<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление таблицей Gorod</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .gorod-table {
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
        <h2>Таблица городов</h2>
    </div>
        
    <!-- Вывод таблицы gorod -->
    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $pdo->query("SELECT * FROM gorod ORDER BY nazvanie_gorod"); // Сортировка по названию города
        echo "<table border='1' class='gorod-table'>
            <tr>
                <th>Телефонный код</th>
                <th>Название города</th>
                <th>Страна</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['telefon_cod'] . "</td>";
            echo "<td>" . $row['nazvanie_gorod'] . "</td>";
            echo "<td>" . $row['strana'] . "</td>";
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
            <form action="handle_gorod.php" method="post">
                <label for="telefon_cod">Телефонный код:</label>
                <input type="text" id="telefon_cod" name="telefon_cod"><br><br>
                <label for="nazvanie_gorod">Название города:</label>
                <input type="text" id="nazvanie_gorod" name="nazvanie_gorod"><br><br>
                <label for="strana">Страна:</label>
                <input type="text" id="strana" name="strana"><br><br>
                <input type="submit" value="Добавить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Изменить запись в таблице</h2>
            <form action="handle_gorod.php" method="post">
                <label for="telefon_cod_upd">Телефонный код:</label>
                <input type="text" id="telefon_cod_upd" name="telefon_cod_upd"><br><br>
                <label for="new_nazvanie_gorod">Новое название города:</label>
                <input type="text" id="new_nazvanie_gorod" name="new_nazvanie_gorod"><br><br>
                <label for="new_strana">Новая страна:</label>
                <input type="text" id="new_strana" name="new_strana"><br><br>
                <input type="submit" value="Изменить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Удалить запись из таблицы</h2>
            <form action="handle_gorod.php" method="post">
                <label for="telefon_cod_del">Телефонный код:</label>
                <input type="text" id="telefon_cod_del" name="telefon_cod_del"><br><br>
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
