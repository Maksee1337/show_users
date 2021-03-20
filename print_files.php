  <table border="1" class="bordered">
        <caption>Список файлов</caption>
        <tr>
            <th>Имя файла</th>
            <th>Кол-во людей</th>
            <th>Ссылка</th>
        </tr>
        <?php foreach ($Files_List as $v){?>
        <tr>
            <td><?php echo $v['filename'];?></td>  <!-- выводим список файлов -->
            <td><?php echo $v['count']-1;?></td> <!-- и количество пользователей в каждом файле -->
            <td><a href="?page=open&file=<?php echo $v['filename'];?>">Открыть</a></td>
        </tr>
        <?php } ?>
  </table>

  <p>
    <a href="?page=adduser">Добавить пользователя.</a>
  </p>

  <p>
      <a href="?page=addfile">Добавить файл с пользователями.</a>
  </p>