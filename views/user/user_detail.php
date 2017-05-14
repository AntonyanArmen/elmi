<?php
    define("PAGE_TITLE", "Просмотр пользователя");
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?= PAGE_TITLE?><br>
            <?php if ($user->is_loaded):?>
                <small>Детали пользователя <?= $user->name ?>.</small>
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
                <label for="name" class="col-md-3 control-label">Имя :</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Имя" required="required" value="<?= $user->name ?>">
                </div>
            </div>
            <button type="button" id="switch-edit-mode" class="btn  btn-success col-md-2"><i class="fa fa-file-o" aria-hidden="true"> </i> Просмотр</button>
            <button type="submit" id="submit-btn" class="btn btn-primary col-md-2 col-md-offset-1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Сохранить</button>
            <button type="button" id="password-btn" class="btn btn-danger col-md-3 col-md-offset-1"><i class="fa fa-key " aria-hidden="true"> </i> Сменить пароль</button>
            <button type="button" id="delete-btn" class="btn btn-warning col-md-2 col-md-offset-1"><i class="fa fa-trash" aria-hidden="true"> </i> Удалить</button>
        </form>
    <?php endif;?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->