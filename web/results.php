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
<script>
    Reveal.initialize({

        // ... add your settings here ...

        // Optional reveal.js plugins
        dependencies: [
            // other dependencies ...

            // add THIS dependency for tagcloud plugin
            { src: 'js/tagcloud.js', async: true }

        ]
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <section tagcloud>
                Twitter Bootstrap
                jQuery
                less
                GruntJS
                JSHint
                JSLint
                markdown
                sass
                jade
                coffeescript
                codekit
                livereload
                web-build
                jQuery UI
                mustache
                emmet.io
                bower
                browserstack
                npm
                RequireJS
                socket.io
                jQuery Mobile
                node.js
                Jasmine
            </section>
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
                    var words = [
                        {text: "Lorem", weight: 13},
                        {text: "Ipsum", weight: 10.5},
                        {text: "Dolor", weight: 9.4},
                        {text: "Sit", weight: 8},
                        {text: "Amet", weight: 6.2},
                        {text: "Consectetur", weight: 5},
                        {text: "Adipiscing", weight: 5},
                        /* ... */
                    ];

                    $('#demo').jQCloud(words);
                </script>
            </p>
        </div>
    </div>

    <br><br><br><br><br><br><br><br>
</div>
<?php

include ('views/footer.php');

?>
