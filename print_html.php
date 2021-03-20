<html lang="ru">
<head>
    <title>Пользователи</title>

    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <?php


        if(array_key_exists('page', $_GET) ){

            if('adduser' == $_GET['page']){
                include "add_user.php";
            }elseif ('addfile' == $_GET['page']){
                include "add_file.php";
            }elseif ('open' == $_GET['page']){
                include "print_users.php";
            }
        }else {
                if ($added == 1) {
                    echo 'Запись добавлена в файл ' . $_POST['filename'];
                }
                if ($add_file_error != 1) {
                    if ($add_file_error == 0) { // выводим сообщение о добавленном файле
                        echo 'Файл успешно добавлен.';
                    } else {
                        switch ($add_file_error) {
                            case -1 :
                                $s = 'Неверный тип файла';
                                break;
                            case -2 :
                                $s = 'Файл не выбран';
                                break;
                            case -3 :
                                $s = 'Файл с таким именем уже сущестувет';
                                break;
                            default:
                                $s = "";

                        }
                        echo '<b>Ошибка загрузки:</b> ' . $s;
                    }
                }
                include "print_files.php";
        }

    ?>

</body>
</html>