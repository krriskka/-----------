
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Planning Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Party Planning Confirmation</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $partyType = $_POST["party-type"];
        $date = $_POST["date"];
        $guests = $_POST["guests"];
        $additionalInfo = $_POST["additional-info"];
        
        // Ваш код обработки бронирования вечеринки, например, сохранение данных в базе данных или отправка на почту
        // Здесь просто выводим информацию о бронировании
        echo "<p>Your $partyType party for $guests guests on $date has been successfully booked.</p>";
        echo "<p>Additional information: $additionalInfo</p>";
    } else {
        // Если запрос не был методом POST, выводим сообщение об ошибке
        echo "<p>Sorry, something went wrong with your party planning.</p>";
    }
    ?>
</body>
</html>
