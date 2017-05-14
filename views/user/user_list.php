<?php
    define("PAGE_TITLE", "Список пользователей");
    $apply_js  = ["./js/reports.js"]; 
    $apply_css = ["./css/report.css"];
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= PAGE_TITLE ?></h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row" style="padding-bottom: 20px;">
    <div class="col-lg-2">
        <a href="index.php?cat=user&operation=add" id="add-btn" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"> </i> Новый</a>
    </div>         
</div>
<div class="row">
    <div class="col-lg-12">
            <?php
        if ($message)
        {
            echo $message;
        }
        ?>
        <?php if (count($users) > 0) :?>
            <table class="table table-striped table-bordered" id="users-table">
                <thead>
                    <tr>
                        <?php foreach (User::field_labels() as $key => $header_column) :?>
                        <?php if ($key === 'id' ) {continue;}?>
                        <th><?= $header_column?></th>
                        <?php endforeach;?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) :?>                    
                    <tr class="row-active" id="<?= $user->id?>" onclick=redirect(<?= $user->id?>)>
                        <td><?= $user->name?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table> 
        <?php else :?> 
            <h3 class="error"><?= VIEW_NO_DATA_TO_DISPLAY ?></h3>
        <?php endif;?>
    </div>
    <!-- /.col-lg-12 -->
</div>                
<!-- /.row -->
<div class="row">
    <div class="col-md-2">
        <button type="button" id="add-btn" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"> </i>  Новый</button>
    </div>         
</div> 