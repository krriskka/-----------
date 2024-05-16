
<?php
session_start();
$partyType = $_POST['party-type'];
$date = $_POST['date'];
$guests = $_POST['guests'];
$additionalInfo = $_POST['additional-info'];

// Подключение к базе данных
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7706675"; // Имя пользователя БД
$password = "j3AaYzXKTl"; // Пароль к БД
$dbname = "sql7706675"; // Имя вашей БД


// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_SESSION["UserID"])) {
    $UserID = $_SESSION["UserID"];
}

// Подготовка и выполнение запроса на добавление вечеринки
$sql = "INSERT INTO Parties (UserID, PartyType, Date, Guests, AdditionalInfo) VALUES ('$UserID', '$partyType', '$date', '$guests', '$additionalInfo')";

if ($conn->query($sql) === TRUE) {
    echo "Вечеринка успешно забронирована!";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

// Закрытие соединения
$conn->close();
?>

