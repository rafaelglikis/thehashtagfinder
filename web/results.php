<?php

// Composer
require('../vendor/autoload.php');

// Helpers
require_once('../system/htmlhelper.php');
require_once('../system/texthelper.php');
require_once('../system/contenthelper.php');

// Custom object classes
require_once('../system/url.php');
require_once('../system/hashtag.php');

// Header
include ('views/header.php');

// Creating the url object
$sourse = new Url($_POST["url"])
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <!-- Status bar -->
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active">Results for: <?php echo $sourse->getUrl()?> </li>
            </ol>
            <!-- Results -->
            <div class="panel panel-default">
                <!-- Title -->
                <div class="panel-heading">
                    <h2 class="panel-title"><?php echo $sourse->getTitle()?></h2>
                </div>
                <div class="panel-body">
                    <br>
                    <br>
                    <!-- Image -->
                    <?php if(filter_var($sourse->getImage(), FILTER_VALIDATE_URL)){ ?>
                        <img class="img-responsive center-block"
                             src="<?php echo $sourse->getImage()?>"
                             alt="<?php echo $sourse->getTitle()?>">
                        <br>
                        <br>
                    <?php } //endIf ?>
                    <!-- Hashtags -->
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
                    <!-- Chart -->
                    <script type="text/javascript">
                        window.onload = function () {
                            var chart = new CanvasJS.Chart("chartContainer",
                                {
                                    theme: "theme1",
                                    title:{
                                        text: "Keywords weight chart",
                                        fontSize: 25
                                    },
                                    legend: {
                                        //maxWidth: 500,
                                        itemWidth: 120
                                    },
                                    height:400,
                                    width:500,
                                    data: [
                                        {
                                            type: "pie",
                                            showInLegend: false,
                                            legendText: "{indexLabel}",
                                            dataPoints: [
                                                    <?php
                                                    $i=0;
                                                    $len = count($hashTags);
                                                    foreach ($hashTags as $hashTag)
                                                    {
                                                    ?>{ y: <?php echo $hashTag->getWeight()?>,
                                                    indexLabel:"<?php echo $hashTag->getName()?>" }<?php if ($i == $len - 1) break;?>,
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
                    <div class="col-xs-12 col-md-6 col-md-offset-3" id="chartContainer"
                         style="height: 500px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

// Footer
include ('views/footer.php');

?>
