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
            <div class="panel-group" id="accordion"
                 role="tablist" aria-multiselectable="true">
                <div class="tab-content">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingPeter">
                            <h3 class="panel-title">
                                <a role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#peter"
                                   aria-expanded="true" aria-controls="peter">
                                    Peter Pan <small>Chief Epicurious Officer</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse in"
                             id="peter"    aria-labelledby="headingPeter">
                            <div class="panel-body">
                                <p>Our CEO, Peter, credits his hardworking East Asian immigrant parents who undertook the arduous journey to the shores of America with the intention of giving their children the best future. His mother's wizardy in the kitchen whipping up the tastiest dishes with whatever is available inexpensively at the supermarket, was his first inspiration to create the fusion cuisines for which <em>The Frying Pan</em> became well known. He brings his zeal for fusion cuisines to this restaurant, pioneering cross-cultural culinary connections.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingDanny">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#danny"
                                   aria-expanded="false" aria-controls="danny">
                                    Dhanasekaran Witherspoon <small>Chief Food Officer</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="danny"    aria-labelledby="headingDanny">
                            <div class="panel-body">
                                <p>Our CFO, Danny, as he is affectionately referred to by his colleagues, comes from a long established family tradition in farming and produce. His experiences growing up on a farm in the Australian outback gave him great appreciation for varieties of food sources. As he puts it in his own words, <em>Everything that runs, wins, and everything that stays, pays!</em></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingAgumbe">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#agumbe"
                                   aria-expanded="false" aria-controls="agumbe">
                                    Agumbe Tang <small>Chief Taste Officer</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="agumbe"    aria-labelledby="headingAgumbe">
                            <div class="panel-body">
                                <p>Blessed with the most discerning gustatory sense, Agumbe, our CFO, personally ensures that every dish that we serve meets his exacting tastes. Our chefs dread the tongue lashing that ensues if their dish does not meet his exacting standards. He lives by his motto, <em>You click only if you survive my lick.</em></p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingAlberto">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                   data-parent="#accordion" href="#alberto"
                                   aria-expanded="false" aria-controls="alberto">
                                    Alberto Somayya <small>Executive Chef</small></a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="alberto"    aria-labelledby="headingAlberto">
                            <div class="panel-body">
                                <p>Award winning three-star Michelin chef with wide International experience having worked closely with whos-who in the culinary world, he specializes in creating mouthwatering Indo-Italian fusion experiences. He says, <em>Put together the cuisines from the two craziest cultures, and you get a winning hit! Amma Mia!</em></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2><?php echo $sourse->getTitle()?></h2>
            <p>Url: <?php echo $sourse->getUrl()?></p>
            <img src="<?php echo $sourse->getImage()?>"
                 alt="<?php echo $sourse->getTitle()?>">
            <div id="whatever">
                <p>
                    <?php
                    $hashTags = $sourse->getHashTags();
                    foreach ($hashTags as $hashTag)
                    {
                        ?>
                        <a href="#" rel="<?php echo $hashTag->getWeight()*1000 ?>">
                            <?php echo $hashTag->getName() ?></a>
                        <?php
                    }
                    ?>
                    <script>
                        $.fn.tagcloud.defaults = {
                            size: {start: 10, end: 26, unit: 'pt'},
                            color: {start: '#CDE', end: '#F52'}
                        };
                        $(function () {
                            $('#whatever a').tagcloud();
                        });
                    </script>
                </p>
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

include ('views/footer.php');

?>
