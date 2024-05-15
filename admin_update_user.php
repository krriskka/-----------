<?php
// Включение вывода ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7706675"; // Имя пользователя БД
$password = "j3AaYzXKTl"; // Пароль к БД
$dbname = "sql7706675"; // Имя вашей БД


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id_to_edit = isset($_GET['id']) ? $_GET['id'] : null;

// Проверяем, есть ли ID для редактирования товара
if ($id_to_edit) {
    // Получаем данные о товаре из базы данных
    $get_product_query = "SELECT * FROM Users WHERE UserID = ?";
    if ($stmt = mysqli_prepare($conn, $get_product_query)) {
        mysqli_stmt_bind_param($stmt, "i", $id_to_edit);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка наличия идентификатора записи
    if(isset($_POST["UserID"]) && !empty(trim($_POST["UserID"]))) {
        $id = trim($_POST["UserID"]);

        // Получение данных из формы
        $VenueID = trim($_POST["UserID"]);
        $VenueName = trim($_POST["Username"]);
        $VenueAddress = trim($_POST["Email"]);
        $VenueCapacity = trim($_POST["Password1"]);
        $VenuePrice = trim($_POST["isAdmin"]);

        // Подготовка SQL запроса на обновление записи
        $sql = "UPDATE Users SET Username=?, Email=?, Password1=?, isAdmin=? WHERE UserID=?";

        if($stmt = mysqli_prepare($conn, $sql)) {
            // Привязка переменных к подготовленному выражению в качестве параметров
            mysqli_stmt_bind_param($stmt, "ssisi", $param_name, $param_brand, $param_type, $param_memory, $param_id);

            // Установка параметров
            $param_name = $Username;
            $param_brand = $Email;
            $param_type = $Password1;
            $param_memory = $isAdmin;
            $param_id = $UserID;

            // Попытка выполнить подготовленный запрос
            if(mysqli_stmt_execute($stmt)) {
                // Запись успешно обновлена, перенаправление на страницу с данными
                header("location: admin.php");
                exit();
            } else {
                echo "Что-то пошло не так. Пожалуйста, попробуйте позже.";
            }

            // Закрытие запроса
            mysqli_stmt_close($stmt);
        }
    } else {
        // Вывод ошибки в случае отсутствия идентификатора записи
        echo "Ошибка: Идентификатор записи не найден.";
    }

    // Закрытие соединения с базой данных
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta content="width=device-width" charset="UTF-8">
    <title>Редактирование сведений о товаре</title>
    <link href="./style_CRUD.css" rel="stylesheet" type="text/css" />
</head>
<body class="body">
<header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=Event+Planner');">
        <h1>Планирование вечеринок и событий</h1>
    </header>
    <nav>
    <a href="main.php">Главная</a>
    <a href="about.php">О нас</a>
    <a href="service.php">Наши услуги</a>
    <a href="admin.php">Страница администратора</a>
    <?php
if(isset($_SESSION['username'])){
    // Если пользователь авторизован, отображаем его имя и кнопку выхода
    echo '<div class="user-info">';
    echo '<a href="account.php">';
    echo '<button>' .$_SESSION['username'] . '</button>';
    echo '</a>';
    echo '</div>';
    echo '<form action="logout.php" method="post">';
    echo '<button type="submit" name="logout">Выйти</button>';
    echo '</form>';
} else {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    echo '<a href="login.html">Войти</a>';
}
?>
</nav>
<div class="create_container">
    <div>
        <form action="admin.php">
            <h1 style="text-align:center;">Редактирование сведений о товаре</h1>
            <!-- Кнопка для возврата на предыдущую страницу -->
            <input type="submit" value="Назад" class="button_red">
        </form>
    </div>
    <div class="grey_container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="UserID" value="<?php echo $id_to_edit; ?>">
            <!-- Скрытое поле для передачи ID товара -->
            <p>
                <label for="Username">Username</label>
                <input class="options_input" type="text" id="Username" name="Username" value="<?php if (isset($_POST['Username'])) echo $_POST['Username']; elseif(isset($product)) echo $product['Username']; ?>">
            </p>
            <p>
                <label for="Email">Email</label>
                <input class="options_input" type="text" id="Email" name="Email" value="<?php if (isset($_POST['Email'])) echo $_POST['Email']; elseif(isset($product)) echo $product['Email']; ?>">
            </p>
            <p>
                <label for="Password1">Password1</label>
                <input class="options_input" type="text" id="Password1" name="Password1" value="<?php if (isset($_POST['Password1'])) echo $_POST['Password1']; elseif(isset($product)) echo $product['Password1']; ?>">
            </p>
            <p>
                <label for="isAdmin">isAdmin (руб.):</label>
                <input class="options_input" type="text" id="isAdmin" name="isAdmin" value="<?php if (isset($_POST['isAdmin'])) echo $_POST['isAdmin']; elseif(isset($product)) echo $product['isAdmin']; ?>">
            </p>
            <!-- Поле для ввода стоимости -->
            <input type="submit" name="submit" value="Сохранить" class="button_green_save">
        </form>
    </div>
</div>
</body>
</html>
