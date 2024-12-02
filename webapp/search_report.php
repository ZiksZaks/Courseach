


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Поиск отчёта</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
            width: 15%;
            background-color: black;
            color: white;
            padding-top: 20px;
            z-index: 1;
        }
        .form-h2 {
            color: black;
            margin: 0;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 2px solid black;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="top-bar">
        <h2>Отчёт по рубрикам в городе</h2>
    </div>
    <div class="sidebar_r">
        <div class="search-header">
            <h2>Выбор рубрики и города для отчёта</h2>
        </div>
        <form id="searchForm" action="" method="post">
            <label for="nazv_rubrika">Название рубрики:</label>
            <select id="nazv_rubrika" name="nazv_rubrika">
            <?php
                $host = 'localhost';
                $dbname = 'Kyrsovik';
                $username = 'postgres';
                $password = 'superuser';
                
                try {
                    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Получение списка рубрик из таблицы rubrika
                    $stmt = $pdo->query("SELECT nazv_rubrika FROM rubrika");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['nazv_rubrika'] . "'>" . $row['nazv_rubrika'] . "</option>";
                    }
                } catch (PDOException $e) {
                    die("Ошибка при получении данных: " . $e->getMessage());
                }
            ?>
            </select><br><br>

            <label for="gorod_organization">Город:</label>
            <select id="gorod_organization" name="gorod_organization">
            <?php
                try {
                    // Получение списка городов из таблицы gorod
                    $stmt = $pdo->query("SELECT nazvanie_gorod FROM gorod");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['nazvanie_gorod'] . "'>" . $row['nazvanie_gorod'] . "</option>";
                    }
                } catch (PDOException $e) {
                    die("Ошибка при получении данных: " . $e->getMessage());
                }
            ?>
            </select><br><br>

            <input type="submit" value="Показать отчёт">
        </form>
        <button class="print-button" onclick="printResults()">Печать</button>
    </div>
    <div id="searchResults"></div>

    <script>
        $(document).ready(function() {
            $('#searchForm').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'handle_search_report.php',
                    data: formData,
                    success: function(response) {
                        $('#searchResults').html(response);
                    }
                });
            });
        });

        function printResults() {
            window.print();
        }
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
