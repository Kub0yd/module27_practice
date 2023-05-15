<form class="auth" method="post">
      <h2>Регистрация</h2>
      <label for="username">Имя пользователя:</label>
      <input type="text" id="username" name="username">
      <label for="password">Пароль:</label>
      <input type="password" id="password" name="password" required>
      <input type="submit" value="Зарегистрироваться" name="registration">
      <div>
        <?php echo '<a href="http://oauth.vk.com/authorize?' . http_build_query( $data ) . '" class="btn btn-primary active reg" role="button" aria-pressed="true">Авторизация через ВКонтакте</a>'; ?>
      </div>
      
</form>