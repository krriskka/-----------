<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    if (isset($_FILES['user-photo'])) {
        $photo = $_FILES['user-photo'];
        $photoName = $photo['name'];
        $photoTmpName = $photo['tmp_name'];
        $photoSize = $photo['size'];
        $photoError = $photo['error'];
        $photoType = $photo['type'];

        $photoExt = explode('.', $photoName);
        $photoActualExt = strtolower(end($photoExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($photoActualExt, $allowed)) {
            if ($photoError === 0) {
                if ($photoSize < 1000000) {
                    $photoNameNew = uniqid('', true) . "." . $photoActualExt;
                    $photoDestination = 'uploads/' . $photoNameNew;

                    if (!is_dir('uploads')) {
                        mkdir('uploads', 0777, true);
                    }

                    if (move_uploaded_file($photoTmpName, $photoDestination)) {
                        $servername = "sql7.freemysqlhosting.net"; // Имя сервера БД
                        $dbUsername = "sql7709451"; // Имя пользователя БД
                        $dbPassword = "4bisLes7Cr"; // Пароль к БД
                        $dbname = "sql7709451"; // Имя вашей БД

                        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "UPDATE Users SET Photo='$photoNameNew' WHERE Username='$username'";

                        if ($conn->query($sql) === TRUE) {
                            echo "Фотография успешно загружена";
                            header("Location: account.php");
                            exit();
                        } else {
                            echo "Ошибка при загрузке фотографии: " . $conn->error;
                        }

                        $conn->close();
                    } else {
                        echo "Не удалось переместить загруженный файл.";
                    }
                } else {
                    echo "Файл слишком большой!";
                }
            } else {
                echo "Ошибка при загрузке файла!";
            }
        } else {
            echo "Файлы такого типа не поддерживаются!";
        }
    }
} else {
    echo "Вы не авторизованы!";
}
?>
