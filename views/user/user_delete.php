<?php
    define("PAGE_TITLE", "Удаление пользователя");
?>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?= PAGE_TITLE?><br>
            <?php if ($user->is_loaded_from_db()):?>
                <small>Подтвердите удаление пользователя <?= $user->name ?>.</small>
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
    <?php if ($user->is_loaded_from_db()):?>
        <form class="form-horizontal" action="" method="post">
            <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
            <button type="submit" id="delete-btn" class="btn btn-danger col-sm-2"><i class="fa fa-trash" aria-hidden="true"> </i> Удалить</button>
            <button type="button" id="cancel-btn" class="btn btn-primary col-sm-2 col-sm-offset-1"><i class="fa fa-undo" aria-hidden="true"></i> Отмена</button>
        </form>
    <?php endif;?>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->