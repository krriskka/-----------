
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Order Confirmation</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $service = $_POST["service"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        
        // Ваш код обработки заказа, например, отправка на почту или сохранение в базе данных
        // Здесь просто выводим информацию о заказе
        echo "<p>Thank you, $name, for ordering $service.</p>";
        echo "<p>We will contact you at $email shortly.</p>";
    } else {
        // Если запрос не был методом POST, выводим сообщение об ошибке
        echo "<p>Sorry, something went wrong with your order.</p>";
    }
    ?>
   

</body>
</html>
