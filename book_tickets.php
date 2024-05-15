<?php
session_start();

// Подключение к базе данных (замените значения на свои)
$servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
$username = "sql7706675"; // Имя пользователя БД
$password = "j3AaYzXKTl"; // Пароль к БД
$dbname = "sql7706675"; // Имя вашей БД


// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");
// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверяем, передан ли параметр event_id в URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Запрос к базе данных для получения информации о мероприятии
    $sql = "SELECT * FROM Events WHERE EventID = $event_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        // Получаем информацию о местах проведения мероприятия (если такая информация есть)
        $venue_name = $event['VenueID'];
        $event_name = $event['EventName'];
        $event_date = $event['EventDate'];
        $event_description = $event['EventDescription'];
        $event_poster = $event['EventPoster'];
    } else {
        echo "Event not found";
        exit;
    }
} else {
    echo "Event ID not provided";
    exit;
}

// Если форма бронирования отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка бронирования билетов
    // Здесь вы можете добавить код для обработки бронирования
    // Например, добавить данные о брони в базу данных
    // и вывести сообщение об успешном бронировании
    $name = $_POST['name'];
    $email = $_POST['email'];
    

    // В этом примере просто выводим информацию о выбранных местах
    echo "<p>Thank you, $name! Your tickets for $event_name on $event_date at $venue_name have been booked.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets</title>
    <link rel="stylesheet" href="assets/css/service.css">
</head>
<body>
    <h1>Book Tickets for <?php echo $event_name; ?></h1>
    <p><?php echo $event_description; ?></p>
    <p>Date: <?php echo $event_date; ?></p>
    <p>Venue: <?php echo $venue_name; ?></p>
    <?php if (!empty($event_poster)) : ?>
        <img src="<?php echo $event_poster; ?>" alt="Event Poster">
    <?php endif; ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Book Tickets">
    </form>
</body>
</html>

<?php
$conn->close();
?>
