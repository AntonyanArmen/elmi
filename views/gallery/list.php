<!-- start news -->
<section id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-header">
                <p class="wow bounceIn animated section-header-text" data-wow-offset="50" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: bounceIn;">Галерея</p>
            </div>
            <?php

            if($images)
            {
                foreach ($images as $value) {
                    $file = AlbumImages::THUMBS_DIR . DIRECTORY_SEPARATOR . $value;
                    /*  img href="<?= Gallery::IMAGE_DIR . DIRECTORY_SEPARATOR . $value?>"*/
                    ?>
                    <div class="col-md-4 gallery-picture-container">
                        <a href="#"  class="pop">
                            <img class="gallery-picture" src="<?= $file?>"  alt="<?= $value->description?>" data-large_img_url="<?= AlbumImages::IMAGE_DIR . DIRECTORY_SEPARATOR . $value?>"/>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="modal-title"></span>
                            </div>
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal">Закрыть<span class="sr-only">Close</span></button>
                                <img src="" class="imagepreview" style="width: 100%;" >
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            else {?>
                <p>Альбом пока пуст. Загляните сюда попозже! </p>
            <?php }?>
        </div>
    </div>
</section>
<!-- end news -->
