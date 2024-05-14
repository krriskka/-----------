
<?php
session_start();
$service = $_POST['service'];
$name = $_POST['name'];
$email = $_POST['email'];

// Подключение к базе данных
$servername = "sql11.freemysqlhosting.net"; // Имя сервера БД
$username = "sql11705022"; // Имя пользователя БД
$password = "YImWifSKV7"; // Пароль к БД
$dbname = "sql11705022"; // Имя вашей БД

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение UserID из сессии или другого места, где он доступен
if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
} 

// Подготовка и выполнение запроса на добавление заказа
$sql = "INSERT INTO Orders (UserID, Service, Name, Email) VALUES ('$userid', '$service', '$name', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Заказ успешно размещен!";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения
$conn->close();
?>
