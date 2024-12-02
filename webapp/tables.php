<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Gorod from PostgresSQL DAtabase using PG.extension</h2>
    <?php
    $connection = pg_connect("host=localhost dbname=Kyrsovik user=postgres password=superuser");
    if (!$connection) {
        echo "An error occurred.<br>";
        exit;
    }
    $result = pg_query($connection,"SELECT * FROM gorod");
    if (!$result) {
        echo "An error occurred.<br>";
        exit;
    }
    ?>

    <table>
        <tr>
            <th>Телефонный код</th>
            <th>Город</th>
            <th>Страна</th>
        </tr>
    </table>

    <?php
    while ($row = pg_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$row[telefon_cod]</td>
            <td>$row[nazvanie_gorod]</td>
            <td>$row[strana]</td>
        </tr>
        ";
    }
    ?>
</body>
</html>