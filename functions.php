<?php
    // файл с моими функциями

/*
 * MyCompare - Функиц сравнения значений. принимает в значения для сравнения, направление сортировки 'up' или 'down' (по возростание, по убыванию ),
 *  и тип данных. или текст - 'text' или дата - 'date' в формате d/m/yyyy
 *
 * */
    function compare_strings($str1, $str2){
        $min = (mb_strlen($str1) < mb_strlen($str2)) ? mb_strlen($str1) : mb_strlen($str2); // определяем длинну более короткой строки
        for($i = 0; $i < $min ; $i++){
            if(mb_ord(mb_substr($str1, $i , 1)) != mb_ord(mb_substr($str2, $i , 1))){ // ищем несовпадение символов
                if(mb_ord(mb_substr($str1, $i , 1)) > mb_ord(mb_substr($str2, $i , 1))){ //если какой то символ не совпал - выходим из функиции с результатом
                    return -1;
                }else{
                    return 1;
                }
            }
        }
        // если до окончания более короткой строки отличий нет. тогда ориентируемся тольк по длинам
        if(mb_strlen($str1) == mb_strlen($str2)){
            return 0; // строки равны
        }
        if(mb_strlen($str1) > mb_strlen($str2)){
            return -1;
        }else{
            return 1;
        }
    }
    function MyCompare($n1 , $n2, $direction = 'up', $type = 'text'){
        if($type == 'text'){ // сравниваем текст в зависимости от параметра type
             $res = (compare_strings($n1, $n2) == 1)? 1 : 0;
             return ($direction == 'up')? $res : !$res;
        }else{
            if($type == 'date'){ // сравниваем даты
                // разбиваем сначала даты на массывы через символ /
                $d1 = explode('/',$n1);
                $d2 = explode('/',$n2);

                if($d1[2] != $d2[2]){ // если годы не совпадают
                    return ($direction == 'up')? $d1[2] > $d2[2]: $d1[2] < $d2[2]; // делаем сравнение по году
                }else{ // если годы совпали
                    if($d1[1] != $d2[1]){ //если месяцы отличаются
                        return ($direction == 'up')? $d1[1] > $d2[1]: $d1[1] < $d2[1]; // делаем сравнение по месяцу
                    }else{ // если месяцы совпали
                        return ($direction == 'up')? $d1[0] > $d2[0]: $d1[0] < $d2[0]; // делаем сравнение по дню
                    }
                }
            }
        }
    }

//MySort - функция сортировки массива по ключу, направлению и типу данных(текст, дата)
    function MySort($array, $key, $direction = 'up', $type = 'text'){
        $count = count($array);
        // сортыровка - пузырь
        for ($i = 0; $i < $count; $i++) {
             for ($j = 0; $j < $count; $j++) {
                 if(MyCompare($array[$i][$key] , $array[$j][$key], $direction, $type)) { // сравниваем значения написаной выше функцией
                     $t = $array[$i];
                     $array[$i] = $array[$j];
                     $array[$j] = $t;
                 }
             }
        }
        return $array;  // возвращаем уже отсортированный массив
    }


// ChangeArgumentInRequestString - формирует на выходе строку с измененными или добавленными параметрами переменной _GET
    function ChangeArgumentInRequestString($agrArray){ // на вход принимаем ассоциативный массив к примеру ['sortby' => 'firstname', 'dir' => 'up' , 'page' => 0]
        $arr = $_GET; // копируем переменную _GET
        foreach ($agrArray as $k => $v) {
            // проходим по принятому массиву agrArray и добавляем или изменяем в массиве arr соответствующие ключи и значение
            $arr[$k] = $v; //
        }
        $res = http_build_query($arr, "&");
        return $res;
    }
