<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" href="assets/css/aboutstyle.css">
    
</head>
<body>
    <header style="background-image: url('https://via.placeholder.com/1500x600/FF5733/000000/?text=About+Us');">
        <h1>О нас</h1>
    </header>
    <nav>
        <a href="main_admin.php">Home</a>
        <a href="about_admin.php">About</a>
        <a href="service_admin.php">Services</a>
        <a href="admin.php">Страница администратора</a>
        <?php
        if (isset($_POST['click']) && !empty($_POST['click'])) {
            // Перенаправляем на создание записи
            header("location:admin_create.php");
        }
            if(isset($_SESSION['username'])){
                echo '<div class="user-info">';
                echo '<a href="account_admin.php">';
                echo '<button>' .$_SESSION['username'] . '</button>';
                echo '</a>';
                echo '</div>';
                echo '<form action="logout.php" method="post">';
                echo '<button type="submit" name="logout">Logout</button>';
                echo '</form>';
            } else {
                echo '<a href="login.html">Login</a>';
            }
        ?>
    </nav>
    <section>
        <h2>Наши услуги</h2>
        <p>Мы предлагаем полный спектр услуг по планированию и организации мероприятий, включая:</p>
        <ul>
            <li>Консультации по планированию мероприятий</li>
            <li>Организация и координация мероприятий</li>
            <li>Декорации и украшения</li>
            <li>Предоставление профессиональной музыки и развлечений</li>
            <li>Кейтеринг и обслуживание гостей</li>
            <li>И многое другое!</li>
        </ul>
    </section>
    <section>
        <h2>Наши преимущества</h2>
        <ul>
            <li>Опытные профессионалы в области организации мероприятий</li>
            <li>Индивидуальный подход к каждому клиенту</li>
            <li>Широкий выбор услуг для различных видов событий</li>
            <li>Гибкий график работы и доступные цены</li>
            <li>Гарантия качества и уникальности в каждой детали</li>
            <li>Отличная репутация и множество довольных клиентов</li>
        </ul>
    </section>
    <section>
        <h2>Наши достижения</h2>
        <p>За многолетнюю деятельность мы имеем ряд достижений и наград, подтверждающих нашу профессиональную репутацию и качество услуг:</p>
        <ul>
            <li>Номинация "Лучший организатор мероприятий" на международной конференции по ивент-менеджменту</li>
            <li>Награда "Золотой Ключ" за инновационный подход к организации свадеб</li>
            <li>Приз "Лучшая декорация года" от журнала "Ивент-стиль"</li>
            <li>И многие другие!</li>
        </ul>
    </section>



    <section>
        <h2>Наша команда</h2>
        <p>Мы - команда профессионалов, специализирующаяся на планировании и проведении вечеринок и событий различного масштаба.</p>
        <p>Наша команда состоит из опытных и творческих специалистов, готовых превратить любое ваше мероприятие в незабываемое событие.</p>
        <div class="team">
            <div class="team-member">
                <img src="https://via.placeholder.com/300" alt="Участник команды 1">
                <h3>Иванова Анна</h3>
                <p>Основатель и руководитель</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/300" alt="Участник команды 2">
                <h3>Петров Владимир</h3>
                <p>Координатор мероприятий</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/300" alt="Участник команды 3">
                <h3>Сидорова Екатерина</h3>
                <p>Дизайнер декораций</p>
            </div>
            <!-- Добавьте больше участников команды с фотографиями и описанием -->
        </div>
    </section>
    
    <section>
        <h2>Наши работы</h2>
        <div class="portfolio">
            <div class="portfolio-item">
                <img src="https://via.placeholder.com/500" alt="Работа 1">
                <p>Описание работы 1</p>
            </div>
            <div class="portfolio-item">
                <img src="https://via.placeholder.com/500" alt="Работа 2">
                <p>Описание работы 2</p>
            </div>
            <div class="portfolio-item">
                <img src="https://via.placeholder.com/500" alt="Работа 3">
                <p>Описание работы 3</p>
            </div>
            <!-- Добавьте больше работ с фотографиями и описанием -->
        </div>
    </section>
    
    <section>
        <div class="mission">
        <h2>Наша миссия</h2>
        </div>
        <div class="mission-item">
        <p>Наша миссия состоит в том, чтобы сделать каждое ваше мероприятие незабываемым и уникальным. Мы стремимся к тому, чтобы каждая деталь была продумана с любовью и вниманием к вашим пожеланиям.</p>
    </div>
        <div class="mission-item">
        <p>Мы верим, что каждое событие - это возможность создать волшебные воспоминания и радость для наших клиентов.</p>
    </div>
    </section>
   
</body>
</html>
