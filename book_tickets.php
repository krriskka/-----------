<?php
session_start();

// Подключение к базе данных (замените значения на свои)
$servername = "sql11.freemysqlhosting.net"; // Имя сервера БД
$username = "sql11705022"; // Имя пользователя БД
$password = "YImWifSKV7"; // Пароль к БД
$dbname = "sql11705022"; // Имя вашей БД

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

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
        $venue_name = $event['VenueName'];
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
    $selected_seats = $_POST['seats'];

    // В этом примере просто выводим информацию о выбранных местах
    echo "<p>Thank you, $name! Your tickets for $event_name on $event_date at $venue_name have been booked.</p>";
    echo "<p>Selected seats: " . implode(", ", $selected_seats) . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Tickets</title>
    <style>
       body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    color: #333;
}

header {
    background-color: #ff7f50;
    color: #fff;
    padding: 30px 20px;
    text-align: center;
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

header h1 {
    font-size: 36px;
    margin: 0;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-family: 'Montserrat', sans-serif;
}

nav .user-info {
    display: inline-block;
    margin-right: 10px;
    line-height: 40px;
}

nav form {
    display: inline-block;
    margin-top: 6px;
}

nav button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: inherit;
    color: inherit;
    padding: 0;
    vertical-align: middle;
    transition: color 0.3s ease;
}

nav {
    background-color: rgba(255, 204, 128, 0.8);
    color: #333;
    padding: 10px;
    text-align: center;
}

nav a {
    color: #333;
    text-decoration: none;
    margin: 0 10px;
    transition: color 0.3s ease;
}

nav a:hover, nav button:hover {
    color: #ff6f00;
}

section {
    padding: 40px 20px;
    margin-top: 40px;
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

p {
    font-size: 18px;
    margin-bottom: 20px;
    line-height: 1.6;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="email"],
input[type="date"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

button[type="submit"] {
    background-color: #ff7f50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #ff6f00;
}

    </style>
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
        <label for="seats">Select Seats:</label><br>
        <!-- Здесь вы можете добавить поле для выбора мест -->
        <!-- Например, список доступных мест с использованием JavaScript -->
        <!-- Пример: <select name="seats[]" multiple>
                        <option value="seat1">Seat 1</option>
                        <option value="seat2">Seat 2</option>
                        ...
                    </select> -->
        <input type="submit" value="Book Tickets">
    </form>
</body>
</html>

<?php
$conn->close();
?>
