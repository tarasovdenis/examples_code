/*Главная страница (выбор пользователя)*/

//выбор диспетчера 
$('.btn_supervisor').button().click(function () {
    window.location.replace("disp/");
});

//выбор заказа такси
//показать подложку и всплывающую форму ввода
$(".btn_user").button().click(function (e) {
    e.preventDefault();
    $(".overlay").fadeIn(400, function () {
        $(".modal_form")
                .css('display', 'inline-block')
                .animate({opacity: 1, top: '50%'}, 200);
    });

});

//клик по подложке закрывает форму
$(".overlay").click(function (e) {
    $(".modal_form").animate({display: 'none'}, 200,
            function () {
                $(this).css('display', 'none');
                $(".overlay").fadeOut(400);
            });
});

//отправка данных
$(".btn_submit").button().click(function (e) {
    e.preventDefault(); //запрет обычной отправки формы
    $.post("ordering.php", $(".modal_form").serialize(), function (data) {
        $("#fields").hide();
        d = JSON.parse(data);

        content = '<b>ФИО: </b>' + d.fio + '<br>' +
                '<b>Email: </b>' + d.email + '<br>' +
                '<b>Откуда: </b>' + d.departure + '<br>' +
                '<b>Куда: </b>' + d.destination + '<br>' +
                '<b>Класс автомобиля: </b>';
        switch (d.car) {
            case 'economy':
                content += 'Эконом';
                break;
            case 'comfort':
                content += 'Комфорт';
                break;
            case 'business':
                content += 'Бизнес';
                break;
        }

        $(".modal_form").html(content);

        //добавление элемента 'Статус заказа'
        var status = document.createElement('p');
        status.setAttribute('id', 'status');
        status.innerHTML = "<b>Статус: </b>Заказ не подтвержден";
        $(".modal_form").append(status);

        //ожидание подтверждения заказа
        setInterval(function () {
            $.post("verification.php", {'id': d.id}, function (data1) {
                d1 = JSON.parse(data1);
                if (d1.status == 0)
                    status.innerHTML = "<b>Статус: </b>Заказ не подтвержден";
                else
                    status.innerHTML = "<b>Статус: </b>Заказ подтвержден";
            });
        }, 2000);
    });
});