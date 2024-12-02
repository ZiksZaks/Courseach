<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Таблица Rubrika</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .rubrika-table {
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
        <h2>Таблица Rubrika</h2>
    </div>
        
    <!-- Вывод таблицы rubrika -->
    <?php
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $stmt = $pdo->query("SELECT * FROM rubrika");
        echo "<table border='1' class='rubrika-table'>
            <tr>
                <th>Название рубрики</th>
                <th>Количество</th>
            </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nazv_rubrika'] . "</td>";
            echo "<td>" . $row['kol_rubrika'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        die("Ошибка при получении данных: " . $e->getMessage());
    }
    ?>

    <div class="forms-container">
        <div>
            <h2 class='form-h2'>Добавить запись в таблицу Rubrika</h2>
            <form action="handle_rubrika.php" method="post">
                <label for="nazv_rubrika">Название рубрики:</label>
                <input type="text" id="nazv_rubrika" name="nazv_rubrika"><br><br>
                <label for="kol_rubrika">Количество:</label>
                <input type="number" id="kol_rubrika" name="kol_rubrika"><br><br>
                <input type="submit" value="Добавить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Изменить запись в таблице Rubrika</h2>
            <form action="handle_rubrika.php" method="post">
                <label for="edit_nazv_rubrika">Старое название рубрики:</label>
                <input type="text" id="edit_nazv_rubrika" name="edit_nazv_rubrika"><br><br>
                <label for="new_nazv_rubrika">Новое название рубрики:</label>
                <input type="text" id="new_nazv_rubrika" name="new_nazv_rubrika"><br><br>
                <label for="new_kol_rubrika">Новое количество:</label>
                <input type="number" id="new_kol_rubrika" name="new_kol_rubrika"><br><br>
                <input type="submit" value="Изменить запись">
            </form>
        </div>

        <div>
            <h2 class='form-h2'>Удалить запись из таблицы Rubrika</h2>
            <form action="handle_rubrika.php" method="post">
                <label for="delete_nazv_rubrika">Название рубрики:</label>
                <input type="text" id="delete_nazv_rubrika" name="delete_nazv_rubrika"><br><br>
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
