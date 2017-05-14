<?php
    define("PAGE_TITLE", "Добавление нового пользователя");
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?= PAGE_TITLE?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12">
    <?php
        if ($message)
        {
            echo $message;
        }
    ?>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">Имя :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Имя" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="control-label col-md-3">Пароль :</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Пароль" required="required">
                </div>
            </div>
            <button type="submit" id="submit-btn" class="btn btn-primary col-md-2"><i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить</button>
        </form>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->