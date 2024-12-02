<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Поиск физического лица</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Поиск физического лица</h2>

    <form action="handle_find_fiz_licho.php" method="post">
        <label for="familia_param">Фамилия:</label>
        <input type="text" id="familia_param" name="familia_param"><br><br>
        <label for="nomer_telefon_param">Номер телефона:</label>
        <input type="number" id="nomer_telefon_param" name="nomer_telefon_param"><br><br>
        <input type="submit" value="Найти">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = 'localhost';
        $dbname = 'Kyrsovik';
        $username = 'postgres';
        $password = 'superuser';

        try {
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $familia_param = $_POST['familia_param'];
            $nomer_telefon_param = $_POST['nomer_telefon_param'];

            $stmt = $pdo->prepare("SELECT * FROM public.find_fiz_licho(:familia_param, :nomer_telefon_param)");
            $stmt->bindParam(':familia_param', $familia_param, PDO::PARAM_STR);
            $stmt->bindParam(':nomer_telefon_param', $nomer_telefon_param, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                echo "<table>
                    <tr>
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Город проживания</th>
                        <th>Улица проживания</th>
                        <th>Дом проживания</th>
                        <th>Номер телефона</th>
                    </tr>";
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['found_familia'] . "</td>";
                    echo "<td>" . $row['found_ima'] . "</td>";
                    echo "<td>" . $row['found_otchestvo'] . "</td>";
                    echo "<td>" . $row['found_gorod_proziv'] . "</td>";
                    echo "<td>" . $row['found_ylicha_proziv'] . "</td>";
                    echo "<td>" . $row['found_dom_proziv'] . "</td>";
                    echo "<td>" . $row['found_nomer_telefon'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Нет результатов для этого запроса.";
            }
        } catch (PDOException $e) {
            die("Ошибка при получении данных: " . $e->getMessage());
        }
    }
    ?>
</body>
</html>
