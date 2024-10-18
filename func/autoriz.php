<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="../css/style.css" />
    <title>Панель управления</title>

</head>

<body>
    <style>
        h1 {
            text-align: center;
            font-weight: 900;
            margin-top: 15px;
            font-size: 40px;
        }



        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {}

        .validation {
            color: #595959;
            font-size: 20px;
        }

        .serch {
            margin-top: 45px;
            background-color: none;
        }

        .car-serch {
            width: 300px;
        }

        .serch-wpap {
            display: flex;
            justify-content: space-between;
            align-items: end;
        }
    </style>
    <?php
    require_once "./config.php";
    $email = $_POST['email'];
    $password = $_POST['password'];

    ?>

    <header class="header">
        <div class="container">
            <div class="header-box">
                <div class="container">
                    <h1 class="header-admin-title">Панель администратора
                        <img src="./img/logo.png" alt="radio-images" width="100px" class="header-logo">
                    </h1>
                    <div class="validation">
                        <?php
                        // Подготавливаем SQL-запрос
                        $sql = "SELECT * FROM users WHERE email = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $email);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        $user = $result->fetch_assoc();

                        // Проверяем, найден ли пользователь и верен ли пароль
                        if ($user && password_verify($password, $user['password'])) {
                            $_SESSION['auth'] = true;
                            $_SESSION['username'] = $user['user_name'];
                            $_SESSION['lastname'] = $user['last_name'];  // Сохраняем имя пользователя в сессии
                            echo "Вы вошли как: " . $_SESSION['username'] . " " . $_SESSION['lastname'] . " | ";  // Выводим пользователя
                        } else {
                            echo "Авторизация не удалась <br> <a href='index.php'>Вернуться на начало</a> <br>";
                        }
                        ?>
                        <a href="/" class="logaut">Выйти</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- end header -->
    <?php
    // проверяем авторизован
    if (!empty($_SESSION['auth'])) {
        require_once './content.html';
    } else {
        echo "<br>!Пользователь не авторизован!!!";
    }
    ?>


    <script src="https://kit.fontawesome.com/cef99322ba.js" crossorigin="anonymous"></script>

</body>

</html>