<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
        <h2>Контент для зарегистрированных пользователей</h2>
        <?php if ($_SESSION['vk_token']){ ?>
        <div class="thumbnail">
            <a data-fancybox href="./app/files/pic1.jpg" data-fancybox >
            <img src="./app/files/pic1.jpg" class="img-fluid" alt="pic1">
            </a>
        </div>  
        <?php } ?>    
    </div>
  </div>
</div> 