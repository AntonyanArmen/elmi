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
                    $file = Gallery::THUMBS_DIR . DIRECTORY_SEPARATOR . $value;
                    ?>
                    <div class="col-md-4 gallery-picture-container">
                        <a href="<?= Gallery::IMAGE_DIR . DIRECTORY_SEPARATOR . $value?>" target="_blank">
                            <img class="gallery-picture"  src="<?= $file?>" alt="<?= $value?>"/>
                        </a>
                    </div>
                    <?php
                }
            }
            else {?>
                <p>Галлерея изображений пуста</p>
            <?php }?>
        </div>
    </div>
</section>
<!-- end news -->
