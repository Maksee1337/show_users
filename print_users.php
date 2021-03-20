<a href="..">Вернуться к списку файлов</a><br><br>

Имя файла: <?php echo $_GET['file']?><br>
Количество пользователей: <?php echo $count?><br>
Пользователей на странице:<a href = "?<?php echo ChangeArgumentInRequestString(['lines' => 'all', 'pagenumber' => 0]);?>">Все</a>  <!-- выбор количества пользователей на странице-->
                          <a href = "?<?php echo ChangeArgumentInRequestString(['lines' => 10, 'pagenumber' => 0]);?>">10</a>
                          <a href = "?<?php echo ChangeArgumentInRequestString(['lines' => 50, 'pagenumber' => 0]);?>">50</a>
                          <a href = "?<?php echo ChangeArgumentInRequestString(['lines' => '100', 'pagenumber' => 0]);?>">100</a><br>

        <?php
            if(array_key_exists('lines', $_GET) && 'all' != $_GET['lines']){
                echo 'Страница: ';
                $current_page = (array_key_exists('pagenumber', $_GET))? $_GET['pagenumber'] : 0;
                for($i = 0 ; $i < $count/$_GET['lines'] ; $i++){    // выводим список страниц в зависимости от того сколько выбрано записей на странице

                    if($i != $current_page) { // не выводим ссылку та некущую страницу
                        echo '<a href="?' . ChangeArgumentInRequestString(['pagenumber' => $i]) . '">' . ($i+1) . '</a> ';
                    }else{
                        echo '<b>('.($i+1).')</b> ';

                    }
                   /*'<a href="?<?php echo ChangeArgumentInRequestString(['pagenumber' => $i]);?>"><?php echo $i+1;?></a>
                */
                }
            }
        ?>




<br><table border="1" class="bordered">  <!-- выводим пользователей -->
    <caption>Список пользователей</caption>
    <tr>
         <th></th>
        <!--
            возле названия каждого столбца добавляем ссылку на сотрировку по этому столбцу. по убыванию или возростанию
            так же указываем что надо начать вывод из первой страницы.
         -->
        <th>Имя(<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'firstname', 'dir' => 'up' , 'pagenumber' => 0]);?>">up</a>/<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'firstname', 'dir' => 'down' , 'pagenumber' => 0]);?>">down</a>)</th>
        <th>Фамилия(<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'lastname', 'dir' => 'up' , 'pagenumber' => 0]);?>">up</a>/<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'lastname', 'dir' => 'down' , 'pagenumber' => 0]);?>">down</a>)</th>
        <th>Дата рождения(<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'dob', 'dir' => 'up' , 'pagenumber' => 0]);?>">up</a>/<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'dob', 'dir' => 'down' , 'pagenumber' => 0]);?>">down</a>)</th>
        <th>Город(<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'city', 'dir' => 'up' , 'pagenumber' => 0]);?>">up</a>/<a href="?<?php echo ChangeArgumentInRequestString(['sortby' => 'city', 'dir' => 'down' , 'pagenumber' => 0]);?>">down</a>)</th>

    </tr>
    <?php for($i = $firts_to_print ; $i < $last_to_print ; $i++){?> <!-- выводим таблицу в зависимости от страницы и кол-ва элеменов на странице. эти значения расчитываются в файле индекс -->
        <tr>
            <td><?php echo $i+1;?></td>
            <td><?php echo $Users_List[$i]['firstname'];?></td>
            <td><?php echo $Users_List[$i]['lastname'];?></td>
            <td><?php echo $Users_List[$i]['dob'];?></td>
            <td><?php echo $Users_List[$i]['city'];?></td>
        </tr>
    <?php } ?>
</table><?php
