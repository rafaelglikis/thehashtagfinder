<?php
// Error Display
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

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
                    <script src="js/Chart.js"></script>
                    <div class="container">
                        <div class="row row-centered">
                            <div id="col-xs-6 col-centered canvas-holder">
                                <canvas id="chart-area" width="500" height="500"/>
                            </div>
                        </div>
                    </div>


                    <script>
                        function getRandomInt(min, max)
                        {
                            return Math.floor(Math.random() * (max - min + 1)) + min;
                        }

                        var colorset = [
                            {
                                color:"#F7464A",
                                highlight: "#FF5A5E"
                            },
                            {
                                color:"#46BFBD",
                                highlight: "#5AD3D1"
                            },
                            {
                                color:"#FDB45C",
                                highlight: "#FFC870"
                            },
                            {
                                color:"#949FB1",
                                highlight: "#A8B3C5"
                            },
                            {
                                color:"#4D5360",
                                highlight: "#616774"
                            }
                        ];
                        var pieData = [
                            <?php
                            $i=0;
                            $len = count($hashTags);
                            foreach ($hashTags as $hashTag)
                            {
                            ?>
                                {
                                    rand: getRandomInt(0, 3)
                                    value: <?php echo $hashTag->getWeight()?>,
                                    color:colorset[this.rand].color,
                                    highlight: colorset[this.rand].highlight,
                                    label: "<?php echo $hashTag->getName()?>"
                                }<?php if ($i > 20) break;?>,
                                <?php $i++;?>
                            <?php
                            }
                            ?>
                        ];
                        window.onload = function(){
                            var ctx = document.getElementById("chart-area").getContext("2d");
                            window.myPie = new Chart(ctx).Pie(pieData);
                        };
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
<?php

// Footer
include ('views/footer.php');

?>
