<!-- start gallery -->
<section id="gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12 section-header">
                <p class="wow bounceIn animated section-header-text" data-wow-offset="50" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: bounceIn;">Галерея</p>
            </div>
            <?php
            if($albums)
            {
                foreach ($albums as $value) {
                    ?>
                    <a href="index.php?cat=gallery&operation=view&album=<?= $value->id ?>">
                        <div class="col-md-4 col-sm-4 col-xs-12 wow fadeInRight" data-wow-offset="50" data-wow-delay="0.6s">
                            <div class="media">
                                <div class="media-heading-wrapper">
                                    <p class="media-heading"><?= $value->name ?></p>
                                    <?php
                                        if ($value->cover){
                                            $file = AlbumImages::THUMBS_DIR . DIRECTORY_SEPARATOR . $value->cover;
                                            ?>
                                            <div >
                                                <img class="album-cover" src="<?= $file?>">
                                            </div>

                                            <?php
                                        }

                                    ?>

                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            }
            else {?>
                <p>Похоже, все альбомы куда то подевались... Мы их попозже обязательно разыщем и вернём!</p>
            <?php }?>
        </div>
    </div>
</section>
<!-- end gallery -->
