<?php
class Model_Registration extends Model
{
	public function get_data()
	{
        //Авторизация VK
        // Параметры приложения
        // $clientId     = '51639289'; // ID приложения
        $clientId     = '51624420'; // ID приложения
        // $clientId     = '51639321'; // ID приложения 3
        // $clientSecret = 'fAApz32aq1tMEoWXe9jd'; // Защищённый ключ
        $clientSecret = 'S4iTqXVQ2chUHeTsPs8T'; // Защищённый ключ testapi
        // $clientSecret = 'sVBvJ0uphHYNpCzgqIxx'; // Защищённый ключ 3
        // $redirectUri  = 'https://kubtech.ru/oauth.php'; // Адрес, на который будет переадресован пользователь после прохождения авторизации
        $redirectUri  = 'http://localhost/module27_practice/0auth.php';
        // Формируем ссылку для авторизации
        $data = array(
          'client_id'     => $clientId,
          'redirect_uri'  => $redirectUri,
          'response_type' => 'code',
          'v'             => '5.126', // (обязательный параметр) версиb API https://vk.com/dev/versions
          // Права доступа приложения https://vk.com/dev/permissions
          // Если указать "offline", полученный access_token будет "вечным" (токен умрёт, если пользователь сменит свой пароль или удалит приложение).
          // Если не указать "offline", то полученный токен будет жить 12 часов.
          'scope'         => 'photo,offline',
        );
        return $data;
    }
}