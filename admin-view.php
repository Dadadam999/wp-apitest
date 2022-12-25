  <p>Плагин регистрирует api endpoints, которые помогают внагрузочномтестировании.</p>

  <p><b>Таблица эндпоинтов.</b></p>

  <table align="left" border="1" cellpadding="1" cellspacing="1" style="width:100%">
    <tbody>
      <tr>
        <td>Описание</td>
        <td>Настройки</td>
      </tr>
      <tr>
        <td>
          <p>Загрузка png картинки на сервер.</p>
          <p>Загружает картинку на сервер, после чего удаляет её.</p>
          <p>Входной параметр:</p>
          <p>wp-apitest-file - файл</p>
          <p>Если файл не корретный вернёт ошибку.</p>
          <p>Если загрузка успешна, вернёт информацию о времени выполнения операции.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/uploadpng HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>;
            <br /> Content-Length: 229
            <br /> Content-Type: multipart/form-data;
            <br /> Content-Disposition: form-data; name=wp-apitest-file; filename=PathToFileOnClient
            <br /> Content-Type: image/png</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Попытка авторизовать пользователя.</p>

          <p>Пытается авторизовать пользователя по логину и паролю. Функция не является иммитацией и при правильном введения логина/пароля авторизирует пользователя.</p>

          <p>Входные параметры:</p>

          <p> wp-apitest-username - text
            <br />  wp-apitest-password - text</p>

          <p>Если хотя бы один из входных параметров пустой, запрос вернёт ошибку.</p>

          <p>Если проверка на авторизацию/авторизация прошла успешно, вернёт вермя выполнения операции.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/trylogin HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 248
            <br /> Content-Type: multipart/form-data;
            <br /> Content-Disposition: form-data; name=wp-apitest-username
            <br /> username-string-here
            <br /> Content-Disposition: form-data; name=wp-apitest-password</p>

          <p>passworf-string-here</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Создаёт текстовый файл с lorem стандартного размера после операции удаляет его.</p>

          <p>Возвращает время выполнения операции, входных параметров нет.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/writefiletxt HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 38
            <br /> Content-Type: multipart/form-data;</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Выводит блок phpinfo.</p>

          <p>Возвращает время выполнения операции, входных параметров нет.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/phpinfo HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 38
            <br /> Content-Type: multipart/form-data;</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Обращается к базе данных и выполняет простойSQL запрос к таблице posts.</p>

          <p>Возвращает время выполнения операции, входных параметров нет.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/shortsql HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 38
            <br /> Content-Type: multipart/form-data;</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Обращается к базе данных и выполняет сложный SQL запроск таблицамposts и postmeta.</p>

          <p>В запросе используются следующие конструкции: вложенный запрос, left join, group by, count, replace, like.</p>

          <p>Возвращает время выполнения операции, входных параметров нет.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/longsql HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 38
            <br /> Content-Type: multipart/form-data;</p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Пустой скрипт, который возвращает всегда 0 микросекунд времени выполнения. Можно использовать, как эталон, для сравнения с серверным времененм выполнения операций.</p>

          <p>Возвращает время выполнения операции, входных параметров нет.</p>
        </td>
        <td>
          <p>POST /wp-json/wp-apitest/v1/emptypoint HTTP/1.1
            <br /> Host: <?= get_site_url(); ?>
            <br /> Content-Length: 38
            <br /> Content-Type: multipart/form-data;</p>
        </td>
      </tr>
    </tbody>
  </table>
