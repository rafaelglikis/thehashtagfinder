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
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Results for: <?php echo $sourse->getUrl()?> </li>
            </ol>

            <div id="whatever">
                <p>
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
                            color: {start: '#CCF', end: '#337'}
                        };
                        $(function () {
                            $('#whatever a').tagcloud();
                        });
                    </script>
                </p>
            </div>
            <br>
            <br>
            <div class="panel-group" id="accordion"
                 role="tablist" aria-multiselectable="true">
                <div class="tab-content">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTitle">
                            <h3 class="panel-title">
                                <a role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#title"
                                   aria-expanded="true" aria-controls="title">
                                    Title <small>Title of given url</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse in"
                             id="title"    aria-labelledby="headingTitle">
                            <div class="panel-body">
                                <p><?php echo $sourse->getTitle()?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    if(filter_var($sourse->getImage(), FILTER_VALIDATE_URL))
                    {

                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingImage">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#image"
                                   aria-expanded="false" aria-controls="image">
                                    Main Image <small>An image of the url that describe it's content most.</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="image"    aria-labelledby="headingImage">
                            <div class="panel-body">
                                <img src="<?php echo $sourse->getImage()?>"
                                     alt="<?php echo $sourse->getTitle()?>">
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingHashTags">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#hashTags"
                                   aria-expanded="false" aria-controls="hashTags">
                                    #hashtags <small>Top 10 keywords</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="hashTags"    aria-labelledby="headingHashTags">
                            <div class="panel-body">
                                    <?php
                                    foreach ($hashTags as $hashTag)
                                    {
                                        echo $hashTag->getWeight() . "\t" . $hashTag->getName()  . '<br>';
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

include ('views/footer.php');

?>
