<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Аутентификация</title>
    <style>
        body {
            background-color: beige;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 900px; /* Увеличенная ширина белого окна */
            max-width: 80%; /* Максимальная ширина окна для маленьких экранов */
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: black;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: black;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: black;
            color: white;
            cursor: pointer;
        }
        .error-message {
            display: none;
            color: red;
            border: 1px solid red;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .show-error {
            display: block;
        }
    </style>
</head>
<body>
    <?php
    $errorMessage = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $login = $_POST['login'];
        $userPassword = $_POST['password'];

        // Проверка пользователя в базе данных
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
        $stmt->execute([$login, $userPassword]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Если пользователь найден, переход к tables.php
            header('Location: main.php');
            exit();
        } else {
            // Если пользователь не найден, устанавливаем сообщение об ошибке
            $errorMessage = 'Неправильный логин или пароль. Попробуйте снова.';
        }
    }
    ?>
    
    <div class="login-container">
        <form action="login.php" method="post">
            <h2>Вход</h2>
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="Войти">
            <div class="error-message <?php if(!empty($errorMessage)) echo 'show-error'; ?>"><?php echo $errorMessage; ?></div>
        </form>
    </div>
</body>
</html>
