<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="cleartype" content="on"/>
    <link rel="dns-prefetch" href="//google-analytics.com/">
    <link rel="dns-prefetch" href="//fonts.googleapis.com/">
    <link rel="dns-prefetch" href="//api-maps.yandex.ru./">
    <title><?= isset($title) && $title ? $title : DEFAULT_PAGE_TITLE ?></title>
    <meta name="keywords" content="бассейн для детей, малышей, ростов-на-дону, грудничковое плавание, занятия, детский аквацентр, аквааэробика для беременных, элми">
    <meta name="description" content="Детский аквацентр «Элми» приглашает малышей на занятия в бассейн; грудничковое плавание и аквааэробика для беременных по доступным ценам в Ростове.">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" type="image/png" href="./favicon.png"/>
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Scada|Seymour+One|Ubuntu&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <?php
    if(isset($apply_css))
    {
        if (is_array($apply_css)) {
            foreach ($apply_css as $css) { ?>
                <link href="<?php echo $css; ?>" rel="stylesheet">
                <?php
            }
        }
        else { ?>
            <link href="<?php echo $apply_css; ?>" rel="stylesheet">
            <?php
        }
    }
    ?>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/elmi.css">
    <link rel="stylesheet" href="css/services.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.singlePageNav.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/custom.min.js"></script>
    <noscript>
        <style>
            .preloader
            {
                display: none !important;
            }
        </style>
    </noscript>
</head>
<body>

<!-- start preloader -->
<div class="preloader">
    <div class="sk-spinner sk-spinner-wave">
        <div class="sk-rect1"></div>
        <div class="sk-rect2"></div>
        <div class="sk-rect3"></div>
        <div class="sk-rect4"></div>
        <div class="sk-rect5"></div>
    </div>
</div>
<!-- end preloader -->
<!-- start header -->
<header id="top" class="templatemo-nav">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <p class="header-phone"><i class="fa fa-phone">&nbsp; </i><a href="tel:+7(863)221-41-35"  class="external">+7(863) 221-41-35</a></p>
            </div>
            <div class="col-md-3 col-sm-3 col-sm-push-3 col-xs-6">
                <p><i class="fa fa-envelope-o "></i> <a href="mailto:info@elmi161.ru" class="external">info@<span class="hide">null</span>elmi161.ru</a></p>
            </div>
            <div class="col-md-3 col-sm-3 col-sm-pull-3 col-xs-6">
                <p class="header-phone"><i class="fa fa-phone">&nbsp; </i><a href="tel:+7(863)210-01-04" class="external">+7(863) 210-01-04</a></p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <ul class="social-icon">
                    <li><span>Cоц. сети</span></li>
                    <!--<li><a href="#" class="fa fa-facebook"></a></li>-->
                    <li><a href="https://vk.com/public137018970" class="fa fa-vk external" target="_blank" ></a></li>
                    <li><a href="https://www.instagram.com/elmi_akva/" class="fa fa-instagram external" target="_blank" ></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nav-container">
        <div class="container">
            <div class="row">
                <!-- start navigation -->
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon icon-bar"></span>
                            <span class="icon icon-bar"></span>
                            <span class="icon icon-bar"></span>
                        </button>
                        <a href="index.html#top" class="navbar-brand <?= isset($not_main_page)&$not_main_page? ' external': ''?>"><i class="fa fa-home"></i> ЭЛМИ</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.html#news" <?= isset($not_main_page)&$not_main_page? 'class="external"': ''?> >Новости и акции</a></li>
                            <li><a href="index.html#service" class="<?php  echo isset($not_main_page)&$not_main_page? 'external ': ''; echo isset($service_subpage)&$service_subpage? ' current': '' ?>"><?= isset($service_subpage)&$service_subpage? '<<': ''?> Услуги</a></li>
                            <li><a href="index.html#team" <?= isset($not_main_page)&$not_main_page? 'class="external"': ''?>>Организация работы</a></li>
                            <li><a href="index.html#contact" <?= isset($not_main_page)&$not_main_page? 'class="external"': ''?>>Контакты</a></li>
                            <li><a href="gallery.html" class="<?php  echo isset($not_main_page)&$not_main_page? 'external ': ''; echo isset($images)? ' current': '' ?>">Галерея</a></li>
                            <li><a href="construct.html" class="external">Отзывы</a></li>
                        </ul>
                    </div>
                </nav>
                <!-- end navigation -->
            </div>
        </div>
    </div>
</header>
<!-- end header -->

<?= $content ?>

<!-- start copyright -->
<footer id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10 text-center col-md-offset-1">
                <p class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">
                    Copyright &copy; 2017 «ЭЛМИ»</p>
            </div>
            <div class="col-md-1 text-center">
                <!— Yandex.Metrika informer —>
                <a href="https://metrika.yandex.ru/stat/?id=43100419&amp;from=informer"
                   target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/43100419/3_0_FFFFFFFF_EFEFEFFF_0_pageviews"
                                                       style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="43100419" data-lang="ru" /></a>
                <!— /Yandex.Metrika informer —>

                <!— Yandex.Metrika counter —>
                <script type="text/javascript">
                    (function (d, w, c) {
                        (w[c] = w[c] || []).push(function() {
                            try {
                                w.yaCounter43100419 = new Ya.Metrika({
                                    id:43100419,
                                    clickmap:true,
                                    trackLinks:true,
                                    accurateTrackBounce:true,
                                    webvisor:true
                                });
                            } catch(e) { }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () { n.parentNode.insertBefore(s, n); };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = "https://mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f, false);
                        } else { f(); }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript><div><img src="https://mc.yandex.ru/watch/43100419" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!— /Yandex.Metrika counter —>

            </div>
        </div>
    </div>
</footer>
<!-- end copyright -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-90912233-1', 'auto');
    ga('send', 'pageview');

</script>
<?php
$pos = mb_strpos($view_name, "/");
if ($pos > 0)
{
    $view_name = mb_substr($view_name, $pos+1);
}
$file_name = "js/{$view_name}.js";
if (file_exists($file_name))
{
    echo '<script type="text/javascript" src="' . $file_name . '"></script>';
}
if( isset($apply_js))
{
    if (is_array($apply_js)) {
    foreach ($apply_js as $js) { ?>
        <script type="text/javascript" src="<?php echo $js; ?>"></script>
    <?php
    }
    }
    else { ?>
        <script type="text/javascript" src="<?php echo $apply_js; ?>"></script>
        <?php
    }
}
?>
</body>
</html>