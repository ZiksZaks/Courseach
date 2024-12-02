<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Поиск организации</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .full-table {
            margin-top: 60px;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }
        #searchForm {
            margin-top: 30px;
        }
        #searchResults {
            margin-top: 20px;
        }
        #searchResults table {
            margin-top: 10px;
            border-collapse: collapse;
        }
        .search-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .find-button {
            padding: 8px 20px;
            background-color: #ffffff;
            color: black;
            border: none;
            cursor: pointer;
        }

        .sidebar_r {
            position: fixed;
            top: 40px;
            left: 0;
            width: 12%;
            background-color: black;
            color: white;
            padding-top: 20px;
            z-index: 1;
        }
        .form-h2 {
            color: black;
            margin: 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="top-bar">
        <h2>Полная таблица telefon_organization</h2>
    </div>
    <?php
    // Подключение к базе данных
    $host = 'localhost';
    $dbname = 'Kyrsovik';
    $username = 'postgres';
    $password = 'superuser';

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Вывод полной таблицы telefon_organization
        $stmt = $pdo->query("SELECT * FROM telefon_organization");
        echo "<table class='full-table' border='1'>
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
    
    <div class="sidebar_r">
        <div class="search-header">
            <h2>Поиск организации</h2>
        </div>
        <!-- Форма для ввода параметров поиска -->
        <form id="searchForm" action="" method="post">
            <label for="nazv_organization">Название организации:</label>
            <select id="nazv_organization" name="nazv_organization">
            <?php
            try {
                // Получение списка организаций из таблицы organization
                $stmt = $pdo->query("SELECT nazv_organization FROM organization");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['nazv_organization'] . "'>" . $row['nazv_organization'] . "</option>";
                }
            } catch (PDOException $e) {
                die("Ошибка при получении данных: " . $e->getMessage());
            }
            ?>
        </select><br><br>
            <label for="nomer_telefon">Номер телефона:</label>
            <input type="number" id="nomer_telefon" name="nomer_telefon"><br><br>
            <input type="submit" value="Найти">
        </form>
    </div>

    <!-- Здесь будет вывод результата поиска -->
    <div id="searchResults"></div>

    <script>
        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault(); // Предотвращаем отправку формы по умолчанию

                var formData = $(this).serialize(); // Получаем данные из формы

                // Отправляем асинхронный POST-запрос
                $.ajax({
                    type: 'POST',
                    url: 'handle_search_organization.php', // Обработчик формы
                    data: formData,
                    success: function(response) {
                        $('#searchResults').html(response); // Вставляем результаты поиска на страницу
                    }
                });
            });
        });
    </script>
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
