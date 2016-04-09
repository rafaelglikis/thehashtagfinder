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
            <h1><?php echo $sourse->getTitle()?></h1>
            <br>
            <br>
            <img class="img-responsive center-block"
                 src="<?php echo $sourse->getImage()?>"
                 alt="<?php echo $sourse->getTitle()?>">
            <br>
            <br>
            <div id="tag-cloud">
                <p  class="text-justify">
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
                            $('#tag-cloud a').tagcloud();
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
                    if(filter_var($sourse->getImage(), FILTER_VALIDATE_URL)) { ?>
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
                                <img class="img-responsive center-block"
                                     src="<?php echo $sourse->getImage()?>"
                                     alt="<?php echo $sourse->getTitle()?>">
                            </div>
                        </div>
                    </div>
                    <?php
                    } //endIf?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingHashTags">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#hashTags"
                                   aria-expanded="false" aria-controls="hashTags">
                                    Chart <small>Keyword weight graphically</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="hashTags"    aria-labelledby="headingHashTags">
                            <div class="panel-body">
                                <script type="text/javascript">
                                    window.onload = function () {
                                        var chart = new CanvasJS.Chart("chartContainer",
                                            {
                                                title:{
                                                    text: ""
                                                },
                                                legend: {
                                                    maxWidth: 800,
                                                    itemWidth: 200
                                                },
                                                data: [
                                                    {
                                                        type: "pie",
                                                        showInLegend: true,
                                                        legendText: "{indexLabel}",
                                                        dataPoints: [
                                                            <?php
                                                                $i=0;
                                                                $len = count($hashTags);
                                                                foreach ($hashTags as $hashTag)
                                                                {
                                                                    ?>{ y: <?php echo $hashTag->getWeight()?>, indexLabel:"<?php echo $hashTag->getName()?>" }<?php if ($i == $len - 1) break;?>,
                                                                    <?php $i++;?>
                                                                <?php
                                                                }
                                                            ?>
                                                        ]
                                                    }
                                                ]
                                            });
                                        chart.render();
                                    }
                                </script>
                                <script type="text/javascript" src="js/canvasjs.min.js"></script>
                                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
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
