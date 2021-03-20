<form action="index.php" method="post" class="form">
    <h1 class="form_title" >Заполните форму</h1>
    <div class="form_grup">
        <input class="form_input" name="firstname"  placeholder="Имя"  required="required"  />
    </div>

    <div class="form_grup">
        <input class="form_input" name="lastname" placeholder="Фамилия"  required="required" />
    </div>

    <div class="form_grup">
        <input class="form_input" type="date" name="dob" placeholder="Дата рождения" required="required" />
    </div>

    <div class="form_grup">
        <input class="form_input" name="city"  placeholder="Город" required="required"  />
    </div>

    <?php
    foreach ($files as $v){ // выводим радио баттоны с именами файлов
        echo '<p><input required="required" type="radio" name="filename" value="'.basename($v).'" /> Добавить в файл '.basename($v).'</p>';
    }
    ?>



    <button class="form_button" type="submit">Добавить</button> <button class="form_button"  type="reset">Сбрость</button>
</form>