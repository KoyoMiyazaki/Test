<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
    <?php
      require_once('./lib/my_lib.php');
    ?>
    <div class="container">
      <h2>ユーザ管理</h2>

      <h3>ユーザ追加</h3>
      <?= my_lib\get_user_registration(); ?>

      <h3>ユーザ一覧</h3>
      <div class="result">
      <?php if (count($_GET) == 0): ?>
        <?= my_lib\get_user_table(); ?>
      <?php endif; ?>
      </div>
      <!-- <div class="card">
        <p class="card-text">1</p>
        <div class="buttons">
          <form>
            <input type="hidden" name="value" value="1" />
          </form>
          <button class="up-button">↑</button>
          <button class="down-button">↓</button>
        </div>
      </div>

      <div class="card">
        <p class="card-text">2</p>
        <div class="buttons">
          <form>
            <input type="hidden" name="value" value="2" />
          </form>
          <button class="up-button">↑</button>
          <button class="down-button">↓</button>
        </div>
      </div>

      <div class="card">
        <p class="card-text">3</p>
        <div class="buttons">
          <form>
            <input type="hidden" name="value" value="3" />
          </form>
          <button class="up-button">↑</button>
          <button class="down-button">↓</button>
        </div>
      </div> -->

    </div>
    <script src="main.js"></script>
  </body>
</html>
