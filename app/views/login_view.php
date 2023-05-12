
    <form method="post">
      <h2>Авторизация</h2>
      <label for="username">Имя пользователя:</label>
      <input type="text" id="username" name="username">
      <label for="password">Пароль:</label>
      <input type="password" id="password" name="password" required>
      <input type="submit" value="Войти" name="login">
      <label>
        Запомнить меня
        <input type="checkbox" name="saveCookie">
      </label>
      <div>
        <!-- <?php echo '<a href="http://oauth.vk.com/authorize?' . http_build_query( $params ) . '">Авторизация через ВКонтакте</a>'; ?> -->
      </div>
      
    </form>
