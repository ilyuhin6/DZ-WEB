<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <style>
        h1 {
            text-align: center;
            color: black;
            font-weight: 900;
            margin-top: 15px;
        }

        .validation {
            font-weight: 900;
            background-color: aliceblue;
            width: 38%;
            margin: 0 auto;
            margin-top: 50px;
            border-radius: 15px;
            padding: 20px 45px;
            font-size: 23px;
        }

        /* Для экранов с шириной от 992px до 1200px */
        @media screen and (min-width: 992px) and (max-width: 1200px) {
            h1 {
                text-align: center;
                color: black;
                font-weight: 900;
                margin-top: 15px;
            }

            .validation {
                font-weight: 900;
                background-color: aliceblue;
                width: 38%;
                margin: 0 auto;
                margin-top: 50px;
                border-radius: 15px;
                padding: 20px 45px;
                font-size: 23px;
            }
        }

        /* Для экранов с шириной от 768px до 991px */
        @media screen and (min-width: 768px) and (max-width: 991px) {
            h1 {
                text-align: center;
                color: black;
                font-weight: 900;
                margin-top: 10px;
            }

            .validation {
                font-weight: 900;
                background-color: aliceblue;
                width: 45%;
                margin: 0 auto;
                margin-top: 40px;
                border-radius: 15px;
                padding: 15px 30px;
                font-size: 20px;
            }
        }

        /* Для экранов с шириной до 767px */
        @media screen and (max-width: 767px) {
            h1 {
                text-align: center;
                color: black;
                font-weight: 900;
                margin-top: 5px;
            }

            .validation {
                font-weight: 900;
                background-color: aliceblue;
                width: 60%;
                margin: 0 auto;
                margin-top: 30px;
                border-radius: 15px;
                padding: 10px 20px;
                font-size: 18px;
            }
        }
    </style>
    <?php
    require_once "./config.php";
    // Собираем данные с формы и сохраняем их в переменные
    $name_user = mb_convert_case($_POST['name'], MB_CASE_TITLE);  // Переводим в верхний регистр имяя
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $password_true = $_POST['password-true'];
    // хешурием пароль
    $cripto_passw = password_hash($password, PASSWORD_DEFAULT);
    // ---------------------------------------------

    // Создаем два массива и переменую для вывода успешной регистрации 
    $arr_user = [$name_user, $email, $password];
    $labels = ['Имя', 'mail', 'Пароль'];
    $msg = "Регистрация Успешна!<br> Сохраните Ваши данные<br><br>";

    ?>
    <h1>Проверка введеных даных</h1>
    <div class="validation" id="validation">
        <?php
        // Проверяем все ли заполнено
        if (!empty($name_user) && !empty($password)) {
        } else {
            echo "Не все поля заполнены" . "<br>" . "<a href='/'> Вернуться назад</a>";
            die;
        }
        // проверяем праильно ли введен email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        } else {
            echo "Email не коректный" . "<br>" . "<a href='/'> Вернуться назад</a>";
            die;
        }
        // Проверяем совпадают ли пароли
        if ($password != $password_true) {
            echo "Пароли то не совпадают" . "<br>" . "<a href='/'> Вернуться назад</a>";
            die;
        }
        // Проверяем минимальную длину пароля
        if (strlen($password) < 6) {
            echo "Пароль должен быть минимум 6 симвовлов" .  "<br>" . "<a href='/'> Вернуться назад</a>";
            die;
        }
        // Готовим sql запрос
        $sql = "INSERT INTO userS (first_name,  mail, password) 
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name_user,  $email, $cripto_passw);
        // проверка прошел ли запрос
        if ($stmt->execute()) {
            echo  $msg;
            foreach ($arr_user as $key => $value) {
                echo $labels[$key] . ' - ' . $value . '<br>';
            }
            echo "<br><a href='/'>Сохранил, покинуть страницу</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close(); // Закрываем подготовленный запрос
        $conn->close(); // Закрываем подключение к базе данных
        ?>
    </div>

</body>

</html>