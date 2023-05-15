
<!DOCTYPE html>
<html>
<head>
  <title>Моя галерея изображений</title>
  <link rel="stylesheet" href="app/style/index.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- логотип -->
            <div class="navbar-header">
                <a class="navbar-brand" href="./">Gallery</a>
            </div>
            <!-- вывод кнопок в зависимости от проверки на авторизацию -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                <?php if (!$_SESSION['auth']) {?>
                <li><a href="./index.php?url=login" class="btn btn-secondary">Войти</a></li>
                <li><a href="./index.php?url=registration" class="btn btn-secondary">Зарегистрироваться</a></li>
                <?php } else {?>
                <form action="./" method="post">
                <button type="submit" class="btn btn-primary" name="sign_out" id="logo" formaction="index.php">ВЫЙТИ</button>
                </form>
                <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <?php include $content_view ?>
    </main>
  <div class='message-div message-div_hidden' id='message-div'></div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

</body>
</html>