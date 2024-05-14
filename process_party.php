
<?php
session_start();
$partyType = $_POST['party-type'];
$date = $_POST['date'];
$guests = $_POST['guests'];
$additionalInfo = $_POST['additional-info'];

// Подключение к базе данных
$servername = "sql11.freemysqlhosting.net"; // Имя сервера БД
$username = "sql11705022"; // Имя пользователя БД
$password = "YImWifSKV7"; // Пароль к БД
$dbname = "sql11705022"; // Имя вашей БД

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
}

// Подготовка и выполнение запроса на добавление вечеринки
$sql = "INSERT INTO Parties (UserID, PartyType, Date, Guests, AdditionalInfo) VALUES ('$userid', '$partyType', '$date', '$guests', '$additionalInfo')";

if ($conn->query($sql) === TRUE) {
    echo "Вечеринка успешно забронирована!";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения
$conn->close();
?>

