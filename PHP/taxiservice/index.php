<!DOCTYPE HTML>
<html>
    <head>
        <title>Такси-сервис</title>
        <link rel="stylesheet" href="scripts/jquery-ui-1.12.1.custom/jquery-ui.css">
        <link rel="stylesheet" href="styles/style.css">
        <script type="text/javascript" src="scripts/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="scripts/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    </head>
    <body>

        <div class="btn_user">Заказать такси</div>
        <div class="btn_supervisor">Диспетчер</div>

        <form class="modal_form">
            <ul id="fields">
                <li>
                    <p>ФИО</p>
                    <input type="text" name="fio" value="Иванов Иван Иванович">
                </li>
                <li>
                    <p>Email</p>
                    <input type="email" name="email" maxlength="320" value="comhome@live.ru">
                </li>
                <li>
                    <p>Откуда</p>
                    <input type="text" name="departure" value="Площадь">
                </li>
                <li>
                    <p>Куда</p>
                    <input type="text" name="destination" value="Вокзал">
                </li>
                <li>
                    <p>Класс автомобиля</p>
                    <select name="car">
                        <option value="economy">Эконом</option>
                        <option value="comfort">Комфорт</option>
                        <option value="business">Бизнес</option>
                    </select>
                </li>
                <li>
                    <button type="button" class="btn_submit">Оформить</button>
                </li>
            </ul>
        </form>
        <div class="overlay"></div>
        <div id="result"></div>

        <script type="text/javascript" src="scripts/main.js"></script>
    </body>
</html>