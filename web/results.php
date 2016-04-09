<?php

require('../vendor/autoload.php');

require_once('../system/htmlhelper.php');
require_once('../system/texthelper.php');
require_once('../system/contenthelper.php');

require_once('../system/url.php');
require_once('../system/hashtag.php');

include ('views/header.php');


$sourse = new Url($_POST["url"])

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2><?php echo $sourse->getTitle()?></h2>
            <p>Url: <?php echo $sourse->getUrl()?></p>
            <img src="<?php echo $sourse->getImage()?>"
                 alt="<?php echo $sourse->getTitle()?>">
            <div id="whatever">
                <?php
                $hashTags = $sourse->getHashTags();
                foreach ($hashTags as $hashTag)
                {
                    ?>
                    <a href="#" rel="<?php echo $hashTag->getWeight() ?>">
                        <?php echo $hashTag->getName() ?></a>
                    <?php
                }
                ?>
                <script>
                    $.fn.tagcloud.defaults = {
                        size: {start: 10, end: 26, unit: 'pt'},
                        color: {start: '#02a', end: '#337'}
                    };
                    $(function () {
                        $('#whatever a').tagcloud();
                    });
                </script>
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

include ('views/footer.php');

?>
