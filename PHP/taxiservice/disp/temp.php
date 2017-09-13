<!DOCTYPE HTML>
<html>
    <head>
        <title>Такси-сервис</title>
        <link rel="stylesheet" href="../styles/style.css">
        <link rel="stylesheet" href="../scripts/jquery-ui-1.12.1.custom/jquery-ui.css">
        <script type="text/javascript" src="../scripts/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="../scripts/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    </head>
    <body>
        <script type="text/javascript">
            var mydiv = $('<button>', {
                id: 'mydiv',
                class: 'mydiv',
                text: 'Содержимое блока',
                click:function(){
                    alert(this.id);
                }
            });
            $('body').append(mydiv);
        </script>
    </body>
</html>
