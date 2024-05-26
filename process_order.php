
<?php
session_start();
$service = $_POST['service'];
$name = $_POST['name'];
$email = $_POST['email'];

// Подключение к базе данных
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7709451"; // Имя пользователя БД
$password = "4bisLes7Cr"; // Пароль к БД
$dbname = "sql7709451"; // Имя вашей БД


// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение UserID из сессии или другого места, где он доступен
if(isset($_SESSION["UserID"])) {
    $UserID = $_SESSION["UserID"];
} 

// Подготовка и выполнение запроса на добавление заказа
$sql = "INSERT INTO Orders (UserID, Service, Name, Email) VALUES ('$UserID', '$service', '$name', '$email')";

if ($conn->query($sql) === TRUE) {
    echo "Заказ успешно размещен!";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения
$conn->close();
?>
