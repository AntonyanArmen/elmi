<?php
	define("PAGE_TITLE", "Авторизация");
?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header text-center"><?= PAGE_TITLE?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">Имя :</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Имя" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-md-3">Пароль :</label>
                <div class="col-md-4">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Пароль" required="required">
                </div>
            </div>
            <div class="form-group">
            	<div class="chechbox col-md-offset-3">
                	<label class="checkbox-offset">
                    	<input  type="checkbox" name="remember"  id="remember" value="1"> Запомнить меня
                   	</label>
                </div>
            </div>            
            <button type="submit" id="submit-btn" class="btn btn-primary col-md-4 col-md-offset-3"><i class="fa fa-key" aria-hidden="true"></i> Войти</button>
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->