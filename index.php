<?php
/*
    дописал обработку запроса пост. и вывод файла  с формой для добавления пользователя
*/

include "functions.php"; // функции я описал отдельны файлом

    $count = 0;
    $added = 0;
    $Files_List = null;
    $Users_List = null;
    $add_file_error = 1; //
    if(array_key_exists('filename', $_POST)){   // проверяем есть ли в а посл запросе параметр для файла в который добавлять данные
        $d = explode('-', $_POST['dob']); // подгоним формат даты под наш d/m/yyyy
        $str = $_POST['firstname'].';'.$_POST['lastname'].';'.(int)$d[2].'/'.(int)$d[1].'/'.$d[0].';'.$_POST['city']."\n";
        $r = file_put_contents('UserFiles\\'.$_POST['filename'], $str, FILE_APPEND);
        if($r) {
            $added = 1; // проверяем успешна ли запись , далее переменную added используем для вывода сообщения в файле print_html
        }
    }

    if(array_key_exists('file', $_FILES)){ //проверяем приняли мы массив _FILES
            if(strlen($_FILES['file']['name']) == 0){ // проверяем не пустая ли запись с файлом. загружаем только один файл
            $add_file_error = -2;                     // ошибка -2 файл не выбран
        }else {
            if( 'text/plain' != $_FILES['file']['type']){ // ошибка -1 неверный тип файла
                $add_file_error = -1;
            }else {
                if(file_exists('UserFiles/'.$_FILES['file']['name'])){
                    $add_file_error = -3;
                }else {
                    $add_file_error = 0; // все ок.
                    move_uploaded_file($_FILES['file']['tmp_name'], 'UserFiles/' . $_FILES['file']['name']); // перемещаем файл в нашу папку
                }
            }
        }
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(array_key_exists('page', $_GET) && $_GET['page'] == 'adduser'){
        $files = glob('UserFiles/*.*');
    }else{
        if (!array_key_exists('file', $_GET)) {
            // если параметр file не указан - выводим список файлов
            $files = glob('UserFiles/*.*');
            foreach ($files as $v) {
                $data = file_get_contents($v);   // считываем весь файл в строку
                $a1 = explode("\n", $data); // разбиваем построчно в массив
                $Files_List[] = ['path' => $v, 'filename' => basename($v), 'count' => count($a1)];
            }
        } else { // если параметр file существует , то выводим на страницу пользователей
            $data = file_get_contents('UserFiles\\' . $_GET['file']);
            $a1 = explode("\n", $data); // разбиваем построчно в массив
            $count = 0;
            foreach ($a1 as $v) {
                // создаем из файла ассоциативный массив
                $t = explode(';', $v);
                if(count($t) == 4) {
                    $Users_List[$count++] = ['firstname' => $t[0], 'lastname' => $t[1], 'dob' => $t[2], 'city' => $t[3]];
                    //  $Users_List[$count++] - постинкремен выполняется после получения значения из переменной count. можно было бы написать и отдельно
                }
            }

            if (array_key_exists('sortby', $_GET)) { // если есть параметр для сортировки, то сортируем
                if ($_GET['sortby'] == 'dob') { // даты сортируем с соответствующим аргументом
                    $Users_List = MySort($Users_List, $_GET['sortby'], $_GET['dir'], 'date');
                } else {
                    $Users_List = MySort($Users_List, $_GET['sortby'], $_GET['dir'], 'text');
                }
            }

            // по умолчанию выводим весь список
            $firts_to_print = 0;
            $last_to_print = $count;

            if (array_key_exists('lines', $_GET)) { // если есть параметр line то считаем начало и конец вывода
                if ($_GET['lines'] != 'all') {
                    $firts_to_print = $_GET['lines'] * $_GET['pagenumber'];
                    $last_to_print = ($firts_to_print + $_GET['lines'] < $count) ? $firts_to_print + $_GET['lines'] : $count;
                }
            }
        }
    }


///////////////////////////////////////////////// выше сделали всю логику

    include "print_html.php"; // выводим код страницы