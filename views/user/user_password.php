<?php
    define("PAGE_TITLE", "Смена пароля");
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?= PAGE_TITLE?><br>
            <?php if ($user->is_loaded):?>
                <small>Для пользователя <?= $user->name ?></small>
            <?php endif;?>
        </h3>
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
    <?php if ($user->is_loaded):?>
        <form class="form-horizontal" action="" method="post">
            <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
            <div class="form-group">
                <label for="current_password" class="control-label col-md-4">Текущий пароль :</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Текущий пароль" required="required">
                </div>
            </div>	
            <div class="form-group">
                <label for="new_password" class="control-label col-md-4">Введите новый пароль :</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Новый пароль" required="required">
                </div>
            </div>	
            <div class="form-group">
                <label for="confirm_new_password" class="control-label col-md-4">Повторите ввод нового пароля :</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Новый пароль" required="required">
                </div>
            </div>
            <button type="submit" id="change-password-btn" class="btn  btn-success col-md-12"><i class="fa fa-check" aria-hidden="true"> </i> Сменить пароль</button>
        </form>
    <?php endif;?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->