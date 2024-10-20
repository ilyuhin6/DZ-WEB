<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления</title>
</head>

<body style="background-image: url(../img/fon.jpg); background-size: cover;
background-repeat: no-repeat;">
    <style>
        * {
            box-sizing: border-box;
            font-family: monospace;
        }

        body {
            margin: 0;
            padding: 0;
            position: relative;
        }

        h1,
        p,
        a {
            margin: 0;
            padding: 0;
        }

        .sitebar {
            position: absolute;
            background-color: #242582;
            max-width: 300px;
            left: 0;
            top: 100px;
            border-radius: 10px;
        }

        .sitebar-nav {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 30px;
            list-style: none;
            gap: 10px;
        }

        .sitebar-nav-link {
            text-decoration: none;
            font-weight: 900;
            font-size: 20px;
            color: gray;
        }



        .sitebar-icon {
            color: #000;
            margin-right: 15px;
        }

        a {
            color: orange;
            text-decoration: none;
        }



        .header-admin-box-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header {
            background-color: #242582;
            padding: 20px 0;
        }

        .container {
            max-width: 75%;
            margin: 0 auto;
        }

        .header-admin-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .header-admin-title {
            color: #000;
        }

        .validation {
            font-size: 20px;
            font-weight: 600;
        }

        .true-folse-content {
            display: block;
            width: 40%;
            margin: 0 auto;
            background-color: white;
            color: black;
            font-size: 25px;
            padding: 25px 0;
            text-align: center;
            font-weight: 900;
            margin-top: 50px;
            border-radius: 10px;
        }
    </style>

    <?php
    require_once "./config.php";
    $email = $_POST['mail'];
    $password = $_POST['password'];

    ?>

    <header class=" header">
        <div class="container">
            <div class="header-admin-box">

                <div class="header-admin-box-title">
                    <h1 class="header-admin-title">
                        <i class="fa-solid fa-user"></i>
                        Панель администратора
                    </h1>
                </div>
                <div class="validation">
                    <?php
                    // Подготавливаем SQL-запрос
                    $sql = "SELECT * FROM users WHERE mail = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('s', $email);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();

                    // Проверяем, найден ли пользователь и верен ли пароль
                    if ($user && password_verify($password, $user['password'])) {
                        $_SESSION['auth'] = true;
                        $_SESSION['username'] = $user['first_name'];
                        echo "Вы вошли как: " . $_SESSION['username'];  // Выводим пользователя
                    } else {
                        // echo "Авторизация не удалась <br> <a href='index.php'>Вернуться на начало</a> <br>";
                    }
                    ?>
                    <a href="/" class="logaut">Выйти</a>
                </div>
            </div>
        </div>

    </header>

    <!-- end header -->



    <div class="true-folse-content">
        <?php
        // массив месяцев
        $arr = [
            'январь',
            'февраль',
            'март',
            'апрель',
            'май',
            'июнь',
            'июль',
            'август',
            'сентябрь',
            'октябрь',
            'ноябрь',
            'декабрь'
        ];

        // проверяем авторизован если да показываем дату
        if (!empty($_SESSION['auth'])) {
            $month = date('n') - 1;
            echo "Привет " . "  " . $_SESSION['username'] . "<br>" . "Сегодня" . "<br>";
            echo $arr[$month] . ' ' . date('d, Y');
        } else {
            echo "Авторизация не удалась" . "<br>";
            echo "<a href='/'>Пробуй снова</a> <br>";
            die;
        }
        ?>
    </div>
    <?php
    require_once "../admin-panel.html";
    ?>



    <script src="https://kit.fontawesome.com/cef99322ba.js" crossorigin="anonymous"></script>

</body>

</html>