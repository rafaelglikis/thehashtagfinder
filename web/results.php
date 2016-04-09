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
            <div id="whatever">
                <a href="/path" rel="7">peace</a>
                <a href="/path" rel="3">unity</a>
                <a href="/path" rel="10">love</a>
                <a href="/path" rel="5">having fun</a>
            </div>
            <h2><?php echo $sourse->getTitle()?></h2>
            <p>Url: <?php echo $sourse->getUrl()?></p>
            <img src="<?php echo $sourse->getImage()?>"
                 alt="<?php echo $sourse->getTitle()?>">
            <p>
                <?php
                $hashTags = $sourse->getHashTags();
                foreach ($hashTags as $hashTag)
                {
                   echo $hashTag->getName() . "\t" . $hashTag->getWeight() . '<br>';
                }
                ?>

                <script>
                    $.fn.tagcloud.defaults = {
                        size: {start: 14, end: 18, unit: 'pt'},
                        color: {start: '#cde', end: '#f52'}
                    };

                    $(function () {
                        $('#whatever a').tagcloud();
                    });
                </script>
            </p>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

include ('views/footer.php');

?>
