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
                    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                    <style>
                        #canvas-holder {
                            width: 100%;
                            margin-top: 50px;
                            text-align: center;
                        }
                        #chartjs-tooltip {
                            opacity: 1;
                            position: absolute;
                            background: rgba(0, 0, 0, .7);
                            color: white;
                            padding: 3px;
                            border-radius: 3px;
                            -webkit-transition: all .1s ease;
                            transition: all .1s ease;
                            pointer-events: none;
                            -webkit-transform: translate(-50%, 0);
                            transform: translate(-50%, 0);
                        }
                        #chartjs-tooltip.below {
                            -webkit-transform: translate(-50%, 0);
                            transform: translate(-50%, 0);
                        }
                        #chartjs-tooltip.below:before {
                            border: solid;
                            border-color: #111 transparent;
                            border-color: rgba(0, 0, 0, .8) transparent;
                            border-width: 0 8px 8px 8px;
                            bottom: 1em;
                            content: "";
                            display: block;
                            left: 50%;
                            position: absolute;
                            z-index: 99;
                            -webkit-transform: translate(-50%, -100%);
                            transform: translate(-50%, -100%);
                        }
                        #chartjs-tooltip.above {
                            -webkit-transform: translate(-50%, -100%);
                            transform: translate(-50%, -100%);
                        }
                        #chartjs-tooltip.above:before {
                            border: solid;
                            border-color: #111 transparent;
                            border-color: rgba(0, 0, 0, .8) transparent;
                            border-width: 8px 8px 0 8px;
                            bottom: 1em;
                            content: "";
                            display: block;
                            left: 50%;
                            top: 100%;
                            position: absolute;
                            z-index: 99;
                            -webkit-transform: translate(-50%, 0);
                            transform: translate(-50%, 0);
                        }
                    </style>

                    <div class="container">
                        <div class="row row-centered">
                            <div id="col-xs-6 col-centered canvas-holder">
                                <canvas id="chart-area" width="500" height="500"/>
                            </div>
                        </div>
                    </div>


                    <script>
                        var pieData = [
                            <?php
                            $i=0;
                            $len = count($hashTags);
                            foreach ($hashTags as $hashTag)
                            {
                            ?>
                                {
                                    value: <?php echo $hashTag->getWeight()?>,
                                    //color:"#F7464A",
                                    //highlight: "#FF5A5E",
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

                    <div id="canvas-holder">
                        <canvas id="chart-area1" width="50" height="50" />
                    </div>
                    <div id="canvas-holder">
                        <canvas id="chart-area2" width="300" height="300" />
                    </div>

                    <div id="chartjs-tooltip"></div>


                    <script>
                        Chart.defaults.global.customTooltips = function(tooltip) {
                            // Tooltip Element
                            var tooltipEl = $('#chartjs-tooltip');
                            // Hide if no tooltip
                            if (!tooltip) {
                                tooltipEl.css({
                                    opacity: 0
                                });
                                return;
                            }
                            // Set caret Position
                            tooltipEl.removeClass('above below');
                            tooltipEl.addClass(tooltip.yAlign);
                            // Set Text
                            tooltipEl.html(tooltip.text);
                            // Find Y Location on page
                            var top;
                            if (tooltip.yAlign == 'above') {
                                top = tooltip.y - tooltip.caretHeight - tooltip.caretPadding;
                            } else {
                                top = tooltip.y + tooltip.caretHeight + tooltip.caretPadding;
                            }
                            // Display, position, and set styles for font
                            tooltipEl.css({
                                opacity: 1,
                                left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
                                top: tooltip.chart.canvas.offsetTop + top + 'px',
                                fontFamily: tooltip.fontFamily,
                                fontSize: tooltip.fontSize,
                                fontStyle: tooltip.fontStyle,
                            });
                        };
                        var pieData = [{
                            value: 300,
                            color: "#F7464A",
                            highlight: "#FF5A5E",
                            label: "Red"
                        }, {
                            value: 50,
                            color: "#46BFBD",
                            highlight: "#5AD3D1",
                            label: "Green"
                        }, {
                            value: 100,
                            color: "#FDB45C",
                            highlight: "#FFC870",
                            label: "Yellow"
                        }, {
                            value: 40,
                            color: "#949FB1",
                            highlight: "#A8B3C5",
                            label: "Grey"
                        }, {
                            value: 120,
                            color: "#4D5360",
                            highlight: "#616774",
                            label: "Dark Grey"
                        }];
                        window.onload = function() {
                            var ctx1 = document.getElementById("chart-area1").getContext("2d");
                            window.myPie = new Chart(ctx1).Pie(pieData);
                            var ctx2 = document.getElementById("chart-area2").getContext("2d");
                            window.myPie = new Chart(ctx2).Pie(pieData);
                        };
                    </script>
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
